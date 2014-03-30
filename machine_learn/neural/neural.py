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

	#output (-1, 0, 1 : sell, leave, buy)
	for i in range(0, len(inputs)):
		if i < 2:
			outputs.append(0)
			continue

		left = inputs[i-2]
		mid = inputs[i-1]
		right = inputs[i]

		extreme = (mid - left) * (mid - right)
		if (extreme > 0):
			if ((mid - left) > 0):
				outputs.append(-1)
			else:
				outputs.append(1)
		else:
			outputs.append(0)

	print(inputs)
	print(outputs)

def main():

	#Create Network

	getData()
	conec = imlgraph((1, 5, 3, 5, 1), biases=False)
	net = ffnet(conec)
	net.train_rprop(inputs, outputs)
	savenet(net, "test_net")

if __name__ == "__main__":
    sys.exit(main())
