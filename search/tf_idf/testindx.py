
import sys
import re
from porterStemmer import PorterStemmer
from collections import defaultdict
from array import array
import gc
import math
import pymysql
porter=PorterStemmer()

class CreateIndex:

    def __init__(self):
        # self.index=defaultdict(list)    #the inverted index
        # self.titleIndex={}
        # self.tf=defaultdict(list)          #term frequencies of terms in documents
                                                    #documents in the same order as in the main index
        self.df=defaultdict(int)         #document frequencies of terms in the corpus
        self.numDocuments=0

    def createconn(self):
        self.conn = pymysql.connect(host="localhost",user="root",passwd="",database="search" )
        self.cur = self.conn.cursor()

    def closeconn(self):
        self.cur.close()
        self.conn.commit()
        self.conn.close()

    def getStopwords(self):
        '''get stopwords from the stopwords file'''
        f=open(self.stopwordsFile, 'r')
        stopwords=[line.rstrip() for line in f]
        self.sw=dict.fromkeys(stopwords)
        f.close()


    def getTerms(self, line):
        '''given a stream of text, get the terms from the text'''
        line=line.lower()
        line=re.sub(r'[^a-z0-9 ]',' ',line) #put spaces instead of non-alphanumeric characters
        line=line.split()
        line=[x for x in line if x not in self.sw]  #eliminate the stopwords
        line=[ porter.stem(word, 0, len(word)-1) for word in line]
        return line





    def writeIndexToFile(self,tdict,tf):
        '''write the index to the file'''
        #write main inverted index
        # f=open(self.indexFile, 'w')
        #first line is the number of documents
        self.createconn()
        for termPage, postingPage in tdict.items():
            self.cur.execute('''Select term_index from crawl_index where term=%s''',termPage)
            row = self.cur.fetchone()

            uID=postingPage[0]
            positions=postingPage[1]
            pl=':'.join([str(uID) ,','.join(map(str,positions)),''.join(map(str,tf[termPage]))])

            if not row:
                self.cur.execute('''Insert into crawl_index(term,term_index) values(%s,%s)''',(termPage,pl))

            else:
            # pending#check if uid already present in index
                pl='|'+pl
                self.cur.execute('''update crawl_index set
                            term_index = concat(term_index, %s) where term=%s''',
                            (pl,termPage))


       
        self.closeconn()

    def writeidf(self):
        self.createconn()
        for termPage,idf in self.df.items():
            idfData='%.4f' % (self.numDocuments/idf)      # idf calculations
            idfData='|'+str(idfData)
            # print("idfData",idfData)
            self.cur.execute('''update crawl_index set
                                    term_index = concat(term_index, %s) where term=%s''',
                                    (idfData,termPage))
        self.closeconn()


    def createIndex(self):
        '''main of the program, creates the index'''
        self.createconn()
        self.stopwordsFile="stopWords.dat"
        self.getStopwords()
        # set the total num of urls in database
        self.cur.execute('''SELECT MAX(url_id) FROM crawl_data;''')
        nu=self.cur.fetchone()
        self.numDocuments=nu[0]

        
        gc.disable()



        #main loop creating the index
        # while pagedict != {}:
        self.cur.execute('''Select * from crawl_data''')
        self.closeconn()
        for row in self.cur:
            pagedict={}
            pagedict['id']=row[0]
            pagedict['title']=row[2]
            pagedict['text']=row[3]
            lines='\n'.join((pagedict['title'],pagedict['text']))
            pageid=int(pagedict['id'])
            terms=self.getTerms(lines)


            #build the index for the current page
            termdictPage={}
            tf=defaultdict(list)
            for position, term in enumerate(terms):
                try:
                    termdictPage[term][1].append(position)
                except:
                    termdictPage[term]=[pageid, array('I',[position])]

            #normalize the document vector
            norm=0
            for term, posting in termdictPage.items():
                norm+=len(posting[1])**2
            norm=math.sqrt(norm)

            #calculate the tf and df weights                                    tfidf calculations
            for term, posting in termdictPage.items():
                # self.tf[term].append('%.4f' % (len(posting[1])/norm))
                self.df[term]+=1
                tf[term].append('%.4f' % (len(posting[1])/norm))
            #merge the current page index with the main index
            # for termPage, postingPage in termdictPage.items():
            #     self.createconn()
            #     self.cur.execute('''Select * from crawl_index where term=%s''',termPage)
            #     row = self.cur.fetchone()


            self.writeIndexToFile(termdictPage,tf)
        # for termPage,idf in self.df.items():
            # print(idf)
        self.writeidf()
        gc.enable()

        # self.writeIndexToFile(termdictPage,tf)


if __name__=="__main__":
    c=CreateIndex()
    c.createIndex()


