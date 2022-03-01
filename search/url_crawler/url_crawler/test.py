import scrapy
from scrapy.selector import Selector
from ..items import UrlCrawlerItem
from urllib.parse import urljoin
class QuotesSpider(scrapy.Spider):
    name = 'quotes'
    start_urls = [
        'https://www.vartakpolytechnic.org',
    ]
    

    allowed_domains = ["www.vartakpolytechnic.org"]

    

    def parse(self, response):
        sel = Selector(response)
        url=sel.xpath("//a/@href").extract()
        for url in url:
            url_abs=(response.urljoin(url))
            yield scrapy.Request(url_abs, callback=self.parse_items)


    def parse_items(self,response):
        items=UrlCrawlerItem()
        sel = Selector(response)

        title=sel.xpath("//title/text()").extract()
        # removing any code in text
        # url_text=''.join(sel.xpath("//body//text()[not (ancestor-or-self::script or ancestor-or-self::noscript or ancestor-or-self::style)]").extract()).strip()
        url_text=''.join(sel.xpath('//div[@id="body"]//text()[not (ancestor-or-self::script or ancestor-or-self::noscript or ancestor-or-self::style)]').extract()).strip()
        # removing whitespaces
        url_text=' '.join(url_text.split())
        items['url']=response.url
        items['title']=title
        items['url_text']=url_text

        yield items
