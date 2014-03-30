import numpy as np
import sys
import csv
import json
from ffnet import *
from pymongo import *


global inputs
global outputs

def getData():
	global inputs
	global outputs

	inputs = []
	outputs = []

	#create mongo connection
	client = MongoClient()
	client = MongoClient('mongodb://localhost/')
	db = client.stockDB
	collection = db.APPL_hist

	#input data (close quotes)
	for data in collection.find():
		inputs.append(float(data['close']))

	#set output to future quote
	for i in range(1, len(inputs)):
		outputs.append(inputs[i])

	#make input/output the same length
	inputs.pop()

#	print(inputs)
#	print(outputs)

def main():

	#Create Network

	getData()
	conec = tmlgraph((1, 5, 3, 5, 1), biases=False)
	net = ffnet(conec)
	net.train_rprop(inputs, outputs)
	savenet(net, "test_net")

if __name__ == "__main__":
    sys.exit(main())
