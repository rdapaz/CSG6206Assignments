import os
import sys
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np


class Viz:

    def __init__(self, DSfilepath):
        self.DSfilepath = DSfilepath
        header = ('id', 'Weight', 'Height', 'Gender', 'Category')
        self.df = pd.read_csv(self.DSfilepath, names=header)
        self.gender = self.df['Gender']
        self.category = self.df['Category']
        self.maleWeights = self.df['Weight'][self.gender == 'M']
        self.femaleWeights = self.df['Weight'][self.gender == 'F']

    def plot_histogram(self):
        plt.rcParams['figure.figsize'] = (5, 11)
        plt.rcParams['figure.dpi'] = 150
        plt.subplot(211)
        plt.hist(self.maleWeights, color='lightblue', bins='auto', hatch='x')
        plt.title('Male Weight Distribution')
        plt.xlabel('Weight')
        plt.ylabel('Frequency')
        plt.subplot(212)
        plt.hist(self.femaleWeights, color='pink', bins='auto', hatch='.')
        plt.title('Female Weight Distribution')
        plt.xlabel('Weight')
        plt.ylabel('Frequency')
        plt.show()

    def scatter_plot(self):
        plt.rcParams['figure.figsize'] = (10, 5)
        plt.rcParams['figure.dpi'] = 150
        plt.subplot(121)
        colYG = np.where(self.df['Category'] == 'Yellow', 'yellow', 'green')
        plt.scatter(self.df['Category'], self.df['Height'],
                    s=self.df['Weight'], c=colYG)
        plt.xlabel('Category')
        plt.ylabel('Height')
        plt.title("Heights by Category\n(weight by dot size)")
        plt.subplot(122)
        colMF = np.where(self.df['Gender'] == 'M', 'lightblue', 'pink')
        plt.scatter(self.df['Gender'], self.df['Height'],
                    s=self.df['Weight'], c=colMF)
        plt.xlabel('Gender')
        plt.ylabel('Height')
        plt.title("Heights by Gender\n(weight by dot size)")
        plt.show()


if __name__ == '__main__':
    current_dir = os.path.dirname(sys.argv[0])
    current_path = os.path.join(current_dir, 'files', 'dataset.csv')
    viz1 = Viz(current_path)
    viz1.plot_histogram()
    viz1.scatter_plot()
