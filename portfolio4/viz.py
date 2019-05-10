#!/usr/bin/python3
import matplotlib.pyplot as plt
import numpy as np
import csv
import os
import sys
import pprint
BINS = 10

def pretty_printer(o):
    pp = pprint.PrettyPrinter(indent=4)
    pp.pprint(o)


def plot(lst):
    y_values = np.array(lst)
    print(y_values)
    plt.hist(y_values, normed=True, bins=10)
    plt.show()

def count_elements(seq, bin_size, max_val):
    
    hist = {}

    i = 0
    inc = int(max_val/bin_size)

    while i <= max_val:
        i = max_val if i >= max_val else i
        for el in seq:
            if i <= el < i+inc-1:
                if (i, i+inc-1) not in hist:
                    hist[(i, i+inc-1)] = 0
                hist[(i, i+inc-1)] += 1
        i += inc

    return hist

current_path = os.path.dirname(sys.argv[0])
header = ('id', 'Weight', 'Height', 'Gender', 'Category')

with open(os.path.join(current_path, 'dataset.csv'), 'r') as csvfile:
    dsReader = csv.DictReader(csvfile, fieldnames=header, delimiter=',')
    dsMales = [x for x in dsReader if x['Gender'] == 'M']
    max_val = max(int(x['Weight']) for x in dsMales)
    seq = sorted(int(x['Weight']) for x in dsMales)
    count1 = count_elements(seq, BINS, max_val)
    plot(seq)

    csvfile.seek(0)
    dsReader = csv.DictReader(csvfile, fieldnames=header, delimiter=',')
    dsFemales = [x for x in dsReader if x['Gender'] == 'F']
    seq = sorted(int(x['Weight']) for x in dsFemales)
    count2 = count_elements(seq, BINS, max_val)
    plot(count2)