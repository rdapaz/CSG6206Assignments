from enum import Enum
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

class PlotType(Enum):
    SCATTER = 1
    XY = 2

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

    def scatter_plot(self, plot_type=PlotType.SCATTER):
        if plot_type == PlotType.SCATTER:
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

        elif plot_type == PlotType.XY:

            df = self.df

            # Define the axis for each plot types
            x1 = df[df['Gender']=='M']['Weight']
            y1 = df[df['Gender']=='M']['Height']

            x2 = df[df['Gender']=='F']['Weight']
            y2 = df[df['Gender']=='F']['Height']

            x3 = df[df['Category'] == 'Yellow']['Weight']
            y3 = df[df['Category'] == 'Yellow']['Height']

            x4 = df[df['Category'] == 'Green']['Weight']
            y4 = df[df['Category'] == 'Green']['Height']

            # Initialise the plot
            sns.set_style('whitegrid')
            plt.rcParams['figure.figsize'] = (16, 12)
            plt.rcParams['figure.dpi'] = 150

            # Generate plots in a 2x2 grid
            plt.subplot(221)
            plt.plot(x1, y1, 'bo', alpha=0.9)
            plt.title("Height vs Weight (Males)", fontsize=16)
            plt.xlabel("Weight (kg)")
            plt.ylabel("Height (cm)")

            plt.subplot(222)
            plt.plot(x2, y2, 'ro', alpha=0.9)
            plt.title("Height vs Weight (Females)",fontsize=16)
            plt.xlabel("Weight (kg)")
            plt.ylabel("Height (cm)")

            plt.subplot(223)
            plt.plot(x3, y3, 'yo', alpha=0.9)
            plt.title("Height vs Weight (Yellow)",fontsize=16)
            plt.xlabel("Weight (kg)")
            plt.ylabel("Height (cm)")

            plt.subplot(224)
            plt.plot(x4, y4, 'go', alpha=0.9)
            plt.title("Height vs Weight (Green)",fontsize=16)
            plt.xlabel("Weight (kg)")
            plt.ylabel("Height (cm)")

            plt.show()

        else:
            raise Exception("Error plot not defined")



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
    viz1.scatter_plot(plot_type=PlotType.SCATTER)
    viz1.scatter_plot(plot_type=PlotType.XY)

