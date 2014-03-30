import numpy as np
import sys


def main():

	fp = open('/var/www/machine_learn/neural2/dump', 'r')
	left = float(fp.readline())
	fp.close()
	fp = open('/var/www/machine_learn/neural2/dump', 'w')
	fp.write(sys.argv[1])
	fp.close()

	mid = float(sys.argv[1])
	right = float(sys.argv[2])

	extreme = (mid - left) * (mid - right)
	if (extreme > 0):
		if ((mid - left) > 0):
			print(-1)
		else:
			print(1)
	else:
		print(0)

if __name__ == "__main__":
	sys.exit(main())
