#!/usr/bin/python
import sys
import cgi


def main():
	sum = 0.0
    
	for i in range(1, len(sys.argv), 1):
		sum = sum + float(sys.argv[i])
	
	print(sum)
	return sum

if __name__ == "__main__":
    main()




