#!/usr/bin/ruby

# CSG6206 Assignment 2

def countVowels(filepath)
    # This program will count the number of vowels read from a text
    # file where the path is passed in as the argument

    # We first initialise a hash to hold our vowels and their
    # respective count
    vowelCounter = {}

    # Here we open the file referenced by the filepath variable
    # read all the lines, turning them into lowercase

    File.open(filepath, 'r') do |f|
      f.each_line do |line|
        line.downcase!
        # The code below looks for individual occurrences
        # of each vowel in each line if we have already
        # initialised our counter for that vowel, the counter
        # is incremented, otherwise we initialise the counter
        # and set it to 0
        line.scan(/[aeiou]/) do |vowel|
            unless vowelCounter.keys.include? vowel
              vowelCounter[vowel] = 0
            end
            vowelCounter[vowel] += 1
        end
      end
    end
    # What if the vowel wasn't in the sample text? We would still want
    # to display it in the chart.  This addresses that need
    # Note that %w{a e i o u} = ['a', 'b', 'c', 'd', 'e'] but it is 
    # easier to type
    %w{a e i o u}.each do |vowel|
        # To mix it up a bit we will use the ! not operator 
        # rather than the unless conditional
        if ! vowelCounter.keys.include? vowel
            vowelCounter[vowel] = 0
        end
    end
    # This ensures that the hash is sorted so as to allow it to be
    # displayed in alphabetical order based on the key values
    # i.e. a, e, i, o and u
    vowelCounter = vowelCounter.sort_by { |keys, values| keys }.to_h

    # No need to type return <variable> in ruby, we just
    # enter the variable that is to be returned
    vowelCounter
end


def barChart(countHash, maxSymbols, symbol, debug)
    maxEntry = countHash.max_by {|keys, values| values}
    # maxEntry is comprised of an array containing the maximum key and its count
    # since we are only interested in the key, we take the second element of that
    # array = maxEntry[1]
    maxScore = maxEntry[1]
    # Next we represent the count using the following algorithm:
    # (a) Determine the largest count
    # (b) The element at the key with the highest cound will be represented with
    #     the maximum number of symbols using the following equation
    #     number of symbols = Integer((count * maxSymbols)/maxScore)
    #     Hence if the count is the maxScore, we will get maxSymbols
    # (c) In ruby '*' x 10 = '**********' so we then substitute '*' with 
    #     symbox as we allow the user to change how this is displayed
    countHash.each do |item, count|
        # Next we display the textual graphic representation of the count
        # by doing variable interpolation ruby style.  Note that we 
        # have optionally allowed a count to be displayed at the end
        # if debug is true.
        # The portion "#{debug ? ' ' + count.to_s : ''} either
        # displays 10 preceded by a space if count is 10 and debug is true 
        # or nothing
        puts "#{item}: #{symbol*(count*maxSymbols/maxScore).to_i}" + \
                "#{debug ? ' ' + count.to_s : ''}"
    end
end

# The next line is the main program invocation.  Up until now
# we had functions which could have been included in any program
# however the if __FILE__ = $0 literally means if this is being
# executed as a program (rather than having methods simplymixed in)
# in another program then execute the lines below
if __FILE__ == $0
    # We initially define some constants
    MAX_COUNT = 80
    DEBUG = true
    PATH  = '/home/rdapaz/projects/CSG6206/portfolio2/resources/lorem.txt'
    # We generate a hash, h of the vowelcount by
    # invoking our countVowels function
    h = countVowels(PATH)
    # We generate the bar chart by calling the 
    # barChart function and passing in the appropriate
    # parameters, namely the hash variable containing
    # the counts for each vowel, the maximum
    # number of symbols to be displayed, the symbol to he
    # used in the representation and a DEBUG variable
    # indicating whether the count is to be displayed
    # next to the symbol representation
    barChart(h, MAX_COUNT, '*', DEBUG)
end


