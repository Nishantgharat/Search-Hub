
BOT_NAME = 'url_crawler'

SPIDER_MODULES = ['url_crawler.spiders']
NEWSPIDER_MODULE = 'url_crawler.spiders'



ROBOTSTXT_OBEY = False


ITEM_PIPELINES = {
   'url_crawler.pipelines.UrlCrawlerPipeline': 300,
}
