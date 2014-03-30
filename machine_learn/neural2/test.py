import numpy as np
import sys
import csv
from ffnet import *

global inputs
global outputs

def main():

	if len(sys.argv) != 2:
		print("python test.py [quote]")
	else:
		net = loadnet("test_net")
		output = net.call( [float(sys.argv[1])] )
		print output[0]
	

if __name__ == "__main__":
    sys.exit(main())
