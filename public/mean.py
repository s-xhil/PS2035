#!/usr/bin/python
import sys

def main():
	sum = 0.0
    
	for i in range(1, len(sys.argv), 1):
		sum = sum + float(sys.argv[i])
	
	print(sum/12)
	return sum

if __name__ == "__main__":
    main()




