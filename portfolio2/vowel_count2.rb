#!/usr/bin/ruby

# CSG6206 Assignment 2

def countVowels(filepath)
    # This program will count the number of vowels read from a text
    # file where the path is passed in as the argument

    vowelCounter = {}

    File.open(filepath, 'r') do |f|
      f.each_line do |line|
        line.downcase!
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
    vowelCounter = Hash[ vowelCounter.sort_by { |k, v| k } ]

    vowelCounter
end


def barChart(countHash, maxSymbols, symbol)
    maxEntry = countHash.max_by {|k, v| v}
    maxScore = maxEntry[1]
    countHash.each do |item, count|
        puts "#{item}: " + symbol*(count*maxSymbols/maxScore).to_i + " (#{count})"
    end
end


if __FILE__ == $0
    MAX_COUNT = 100
    DEBUG = true
    path = '/home/rdapaz/projects/CSG6206/portfolio2/resources/lorem.txt'
    h = countVowels(path)
    barChart(h, MAX_COUNT, '*')
end


