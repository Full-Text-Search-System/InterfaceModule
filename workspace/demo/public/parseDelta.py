# coding=utf-8

from loxun import XmlWriter
from StringIO import StringIO
import os
import codecs
import MySQLdb
import sys


out = StringIO()
xml = XmlWriter(out)

xml.addNamespace("sphinx","lll")
#---docset
xml.startTag("sphinx:docset")
# --- schema
xml.startTag("sphinx:schema")
#--- field
'''....'''
xml.tag("sphinx:field",{"name":"filename"})
xml.tag("sphinx:field",{"name":"content"})
'''....'''

#--- /field
xml.endTag() 
#--- /schema

try:
    con = MySQLdb.connect('192.168.33.11', 'admin', '123456', 'laravel')
        
    cursor = con.cursor()
    cursor.execute("SELECT * from rtindices")
    rtindex = cursor.fetchone()
    start_id = rtindex[1]
    end_id = rtindex[2]
    
    cursor.execute("SELECT * from files where id >= %d and id <= %d" % (int(start_id), int(end_id)))
    rows = cursor.fetchall()

    for row in rows:
		id = row[0]
		fileName = row[1]
		location = row[2]+'_'+str(id)

		file = codecs.open("/var/www/demo/public/"+location, 'r', 'utf-8')
		content  = ''
		for line in file:
			content += line

		#-#---  document
		xml.startTag("sphinx:document",{"id":id})

		xml.startTag("filename")
		xml.text(fileName)
		xml.endTag()

		xml.startTag("content")
		xml.text(content)
		xml.endTag()

		xml.endTag()  

except MySQLdb.Error, e:
    sys.exit(1)

finally:
    
    if con:
        con.close()


#---#---  document
xml.endTag()
#--- /docset
xml.close()

print out.getvalue()