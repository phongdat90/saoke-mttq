# Required Libraries
import pdfplumber
import pandas as pd

pdf = pdfplumber.open('bidv.pdf')

page0 = pdf.pages[0]

table = page0.extract_table()

df = pd.DataFrame(columns = table[0])

for i in range(0, len(pdf.pages)):
 page = pdf.pages[i]
 table = page.extract_table()
 each_page_data = pd.DataFrame(table[1:], columns=df.columns)
 df = pd.concat([df, each_page_data], ignore_index=True)
 df.to_csv('data.csv')
