#!/usr/bin/ruby

stream = ARGV[0]

retVal = []
last_c = ""
(stream.scan /\w/).each_with_index do |c, idx|
    if idx == 0
        retVal << c
    elsif c == last_c
        retVal << 0
    else
        retVal << 1
    end
    last_c = c
end

puts "-" * stream.size
puts stream
puts retVal.join ""
puts "-" * stream.size
