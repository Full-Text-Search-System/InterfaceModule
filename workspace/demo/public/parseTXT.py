# coding=utf-8

from loxun import XmlWriter
from StringIO import StringIO
import os
import codecs

def findFile(rootDir): 
	paths = []
	for lists in os.listdir(rootDir): 
		if lists != ".DS_Store":
			paths.append(lists) 
	return paths
       
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

paths = findFile("/var/www/demo/public/file")
for path in paths:
	file = codecs.open("/var/www/demo/public/file/"+path, 'r', 'utf-8')
	tmp = path.rsplit('_', 1)
	fileName = tmp[0]
	content  = ''
	for line in file:
		content += line

	#-#---  document
	xml.startTag("sphinx:document",{"id":tmp[1]})

	xml.startTag("filename")
	xml.text(fileName)
	xml.endTag()

	xml.startTag("content")
	xml.text(content)
	xml.endTag()

	xml.endTag()  

#---#---  document
xml.endTag()
#--- /docset
xml.close()

print out.getvalue()

