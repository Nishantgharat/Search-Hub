
import pymysql

class UrlCrawlerPipeline(object):
    # def __init__(self):
    #     self.createconn()

    def createconn(self):
        self.conn = pymysql.connect(host="localhost",user="root",passwd="",database="search" )
        self.cur = self.conn.cursor()
    def process_item(self, item, spider):
        if(self.check(item)):
            print("hi from main")
            # self.storedb(item)
        # else:
        #     print("boo")
        # if(item['url'] and item['title'][0] and item['url_text']):
        #     print("value present")
        # if not item['url_text']:
        #     print("Empty")

        return item

    def storedb(self,item):
        self.createconn()
        if(item['url'] and item['title'][0] and item['url_text']):
            if(len(item['url_text'])>20):
                
                self.cur.execute('''Insert into crawl_data(url,title,url_text) values(%s,%s,%s)''',
                    (item['url'],
                    item['title'][0],
                    item['url_text']
                    ))
            else:
                print('small text')
        # print("ERROR ERROR ERROR empty")
        self.cur.close()
        self.conn.commit()
        self.conn.close()

    def check(self,item):

        if(item['url'] or item['title'][0] or item['url_text']):
            self.createconn()
            self.cur.execute('''Select url FROM crawl_data WHERE url = %s''',
            (item['url']))
            msg = self.cur.fetchone()
            # print(msg)
            # check if it is empty
            if not msg:
                return True
            self.cur.close()
            self.conn.commit()
            self.conn.close()
