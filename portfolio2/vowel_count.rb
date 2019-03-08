#!/usr/bin/ruby

# CSG6206 Assignment 2

def countVowels(filepath)
    # This program will count the number of vowels read from a text
    # file where the path is passed in as the argument

    vowelCounter = {}

    File.open(filepath, 'r') do |f|
      f.each_line do |line|
        line.scan(/[\w'-]+/) do |word|
            word.downcase!
            word.scan(/[aeiou]/) do |vowel|
            unless vowelCounter.keys.include? vowel
              vowelCounter[vowel] = 0
            else
              vowelCounter[vowel] += 1
            end
          end
        end
      end
    end

    vowelCounter = Hash[ vowelCounter.sort_by { |k, v| k } ]

    vowelCounter
end


def barChart(countHash, maxSymbols, symbol)
    maxEntry = countHash.max_by {|k, v| v}
    maxScore = maxEntry[1]
    countHash.each do |item, count|
        puts "#{item}: " + symbol*(count*maxSymbols/maxScore).to_i
    end
end


if __FILE__ == $0
    MAX_COUNT = 20
    DEBUG = false
    path = '/root/Desktop/CSG6206/portfolio2/resources/lorem.txt'
    h = countVowels(path)
    barChart(h, MAX_COUNT, '*')
    if DEBUG
      h.each {|k, v| puts "#{k}: #{v}"}
    end
end


