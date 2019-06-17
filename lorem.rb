#!/usr/bin/ruby

def word_filter(line)
    words = []
    line.scan /[a-zA-Z0-9,.!?]+/ do |word|
        unless word =~ /^[A-Z]/
            words << word
        end
    end
    return words
end33

def output(text_arr)
    return text_arr.join " "
end

words = []
File.open('lorem.txt', 'r') do |f|
    f.each_line do |line|
        words << word_filter(line)
    end
end

puts output(words)