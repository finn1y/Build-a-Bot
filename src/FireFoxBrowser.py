import os, inspect
import platform
from selenium import webdriver
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as ec
from selenium.webdriver.common.by import By

class Browser():
    def __init__(self):
        self.launch()

    def launch(self):
        root_path = os.path.dirname(os.path.abspath(inspect.getfile(inspect.currentframe()))) + "/.."
        log_path = root_path + "/geckodriver/geckodriver.log"

        if platform.system() == "Windows":
            gecko_path = root_path + "/geckodriver/geckodriver.exe"
        else:
            gecko_path = root_path + "/geckodriver/geckodriver"

        os.environ["MOZ_HEADLESS"] = '1'
        self.browser = webdriver.Firefox(executable_path=gecko_path, log_path=log_path)

    def quit(self):
        self.browser.quit()

    async def youtube(self, query):
        url = "https://www.youtube.com/results?search_query=" + query
        self.browser.get(url)
        
        #accept cookies if needed
        if self.browser.current_url[0:70] == "https://consent.youtube.com/m?continue=https%3A%2F%2Fwww.youtube.com%2":
            agree_button = self.browser.find_element_by_xpath("/html/body/c-wiz/div/div/div/div[2]/div[1]/div[4]/form/div[1]/div/button/span")
            agree_button.click()
        
        #wait for element to load
        element_present = ec.presence_of_element_located((By.XPATH, '//*[@id="video-title"]')) 
        WebDriverWait(self.browser, 5).until(element_present)
        #return url for first search option
        return self.browser.find_element_by_xpath('//*[@id="video-title"]').get_attribute("href") 
        

    async def wiki(self, query):
        url = "https://en.wikipedia.org/wiki/" + query
        self.browser.get(url)

        #check if on wikipedia article or article not found
        try:
            if self.browser.find_element_by_xpath("/html/body/div[3]/div[3]/div[5]/div[1]/table/tbody/tr/td/b").text == "Wikipedia does not have an article with this exact name.":
                raise Exception("Wikipedia does not have an article with this exact name.") 

        finally:
            #if article found wait for element to load
            element_present = ec.presence_of_element_located((By.XPATH, "/html/body/div[3]/div[3]/div[5]/div[1]/p[2]")) 
            WebDriverWait(self.browser, 10).until(element_present)

            return self.browser.find_element_by_xpath("/html/body/div[3]/div[3]/div[5]/div[1]/p[2]").text

    async def google(self, query):
        url = "https://duckduckgo.com/?t=ffab&q=" + query +"&atb=v210-1&ia=web"
        self.browser.get(url)

        #wait for element to load
        element_present = ec.presence_of_element_located((By.XPATH, '/html/body/div[2]/div[5]/div[3]/div/div[1]/div[5]/div[2]/div/h2/a[1]')) 
        WebDriverWait(self.browser, 5).until(element_present)

        links = [self.browser.find_element_by_css_selector(f'#r1-{i} > div:nth-child(1) > h2:nth-child(1) > a:nth-child(1)').get_attribute("href") for i in range(0, 5)]
        #if wikipedia or youtube link don't return as functions for these are separate
        for link in links:    
            if link[8:24] == "en.wikipedia.org" or link[8:23] == "www.youtube.com":
                links.remove(link)

        return links 

