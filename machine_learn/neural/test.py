import numpy as np
import sys
import csv
from ffnet import *

global inputs
global outputs

def main():

	net = loadnet("test_net")
	print(net.call([[454.49]]))

	

if __name__ == "__main__":
    sys.exit(main())
