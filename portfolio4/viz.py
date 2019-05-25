import os
import sys
import matplotlib.pyplot as plt
import pandas as pd
import numpy as np
import seaborn as sns

"""
---------------------------------------------------------
Portfolio 4
---------------------------------------------------------

CSG6226 - 2019 Semester 1

By: Ricardo da Paz

---------------------------------------------------------
"""

class Viz:

    # Initialise the class with the filepath to the file being analysed

    def __init__(self, DSfilepath):
        self.DSfilepath = DSfilepath
        header = ('id', 'Weight', 'Height', 'Gender', 'Category')
        # Use the pandas library to read the CSV file, with the above
        # headings for each column
        self.df = pd.read_csv(self.DSfilepath, names=header)
        # Create gender and category subsets of the data 
        self.gender = self.df['Gender']
        self.category = self.df['Category']
        # Create dataframes for male weights and female weights
        self.maleWeights = self.df['Weight'][self.gender == 'M']
        self.femaleWeights = self.df['Weight'][self.gender == 'F']

    def plot_histogram(self):
        # Initialise the plot
        plt.rcParams['figure.figsize'] = (8, 12)
        plt.rcParams['figure.dpi'] = 150
        # Call the set function of the seaborn library to automatically
        # prettify the plot
        sns.set()
        # We want to create a plot containing two subplots on two rows
        # The first subplot will be on row 1
        plt.subplot(211)
        # Set up the histogram for male weights
        plt.hist(self.maleWeights, color='lightblue', bins='auto', hatch='x')
        plt.suptitle('Weight Distribution by Gender', fontsize=16)
        plt.title('Males', fontsize=14)
        plt.xlabel('Weight (Kg)')
        plt.ylabel('Frequency')
        # This is the second sub-plot on row 2
        plt.subplot(212)
        # Set up the histogram for female weights
        plt.hist(self.femaleWeights, color='pink', bins='auto', hatch='.')
        plt.title('Females', fontsize=14)
        plt.xlabel('Weight (Kg)')
        plt.ylabel('Frequency')
        plt.show()

    def scatter_plot(self):
        # Initialise the plot
        plt.rcParams['figure.figsize'] = (10, 5)
        plt.rcParams['figure.dpi'] = 150
        sns.set()
        # We want to create a plot containing two subplots on the same row (1)
        # The first subplot will be on column 1
        plt.subplot(121)
        colYG = np.where(self.df['Category'] == 'Yellow', 'yellow', 'green')
        plt.scatter(self.df['Category'], self.df['Height'],
                    s=self.df['Weight'], c=colYG)
        plt.xlabel('Category')
        plt.ylabel('Height (cm)')
        plt.title("Heights by Category\n(weight by dot size)")
        # We want to create a plot containing two subplots on the same row (1)
        # The first subplot will be on column 2
        plt.subplot(122)
        colMF = np.where(self.df['Gender'] == 'M', 'lightblue', 'pink')
        plt.scatter(self.df['Gender'], self.df['Height'],
                    s=self.df['Weight'], c=colMF)
        plt.xlabel('Gender')
        plt.ylabel('Height (cm)')
        plt.title("Heights by Gender\n(weight by dot size)")
        plt.show()


if __name__ == '__main__':
    # We get the current folder directory relative from the path that the 
    # script was executed from.  In this case we traverse to the files
    # folder and select the dataset.csv file
    current_dir = os.path.dirname(sys.argv[0])
    current_path = os.path.join(current_dir, 'files', 'dataset.csv')
    # We instantiate our class with the path to the datafile as outlined above
    viz1 = Viz(current_path)
    # We call the plot_histogram method of the viz instance of the Viz Class
    viz1.plot_histogram()
    # We call the scatter_plot method of the viz instance of the Viz Class
    viz1.scatter_plot()
