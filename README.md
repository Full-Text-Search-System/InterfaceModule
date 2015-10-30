# InterfaceModule

We use Laravel to build our website achieve the search and add functions in Sphinx.

##Introduction

The InterfaceModule provides an example website for users to know how to use our Sphinx indexing and searching functions. 

In this module, we have a website built with a PHP framework: laravel. This website has two main functions: search and add.

Searching:

When people input words or phrases and click search button, it will send these information to the indexing module and the indexing module will return the searching results.  

Adding:

When people click the add button and select several files, these files will send to remote indexing and storage machines. In the indexing machine, it will use all the words in these files to rebuild the indexing and update the Sphinx results list. In the storage machine, it will save the related information like file name, file address, the time of last updating.

PS: Atcually in this website, we have login function and you can register a new account and this function ensure that just staff can use the add function.

###Init a Ubuntu 14.04 virtual machine with the required develop envrionment

#####We have upload a vagrant box wiht required development envrionment in https://atlas.hashicorp.com/FTS

first, change vagrantfile configuration:
```
config.vm.box = "FTS/IndexingModule"
```
then,
```
$ vagrant up
```
now, we can ssh to the virtual machine:
```
$ vagrant ssh
```

##Run the module

remember to modify the file name to InterfaceModule
```
$cd InterfaceModule
```
```
$vagrant up
```

Go to browser and type http://localhost:8082/admin


