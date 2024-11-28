from selenium import webdriver
from selenium.webdriver.common.by import By
import mysql.connector
from datetime import datetime
import smtplib

#database connnection
db = mysql.connector.connect(
    host="localhost",
    user="root", 
    password="",  
    database="Price_Tracker"
)
cursor = db.cursor()

 #fetching products to track
cursor.execute("SELECT id, product_name, product_url, target_price FROM tracked_products")
products = cursor.fetchall()

  #web dirver
driver = webdriver.Chrome() 

for product in products:
    product_id, product_name, product_url, target_price = product
    driver.get(product_url)

    try:
        
        price_element = driver.find_element(By.CSS_SELECTOR, "span.a-price-whole")
        current_price = float(price_element.text.replace("$", "").replace(",", "").strip())

        
        cursor.execute(
            "UPDATE tracked_products SET current_price = %s, last_checked = %s WHERE id = %s",
            (current_price, datetime.now(), product_id)
        )
        db.commit()
        print(current_price)
        if current_price <= target_price:
            
            print(f"Price dropped for {product_name}! Current price: {current_price} ")
        else :
            print(f"Price is still high for {product_name} Current price: {current_price} Target Price: {target_price}")
    except Exception as e:
        print(f"Error tracking product {product_name}: {e}")

driver.quit()
cursor.close()
db.close()
