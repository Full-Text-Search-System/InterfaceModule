# InterfaceModule

##Introduction

The InterfaceModule provides an example website for users to know how to use our Sphinx indexing and searching functions. 

In this module, we have a website built with an PHP framework: laravel. This website has two main functions: search and add.

Searching:

When people input words or phrases and click search button, it will send these information to the indexing module and the indexing module will return the searching results.  

Adding:

When people click the add button and select several files, these files will send to remote indexing and storage machines. In the indexing machine, it will use all the words in these files to rebuild the indexing and update the Sphinx results list. In the storage machine, it will save the related information like file name, file address, the time of last updating.


##Steps

In order to install Laravel, we need composer:  
###Install composer  
```
$ sudo php -r "readfile('https://getcomposer.org installer')" | sudo php -- --filename=composer
```  
```
$ sudo mv composer /usr/local/bin/composer
```

###Install Laravel:  
```
$ composer global require "laravel/installer=~1.1"
```
