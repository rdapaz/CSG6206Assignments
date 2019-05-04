import random
import os
import sys
import json
import pprint

def pretty_printer(o):
    pp = pprint.PrettyPrinter(indent=4)
    pp.pprint(o)


current_dir = os.path.dirname(sys.argv[0])

# data below from https://www.ssa.gov/oact/babynames/decades/century.html

data = """
James|Male
Mary|Female
John|Male
Patricia|Female
Robert|Male
Jennifer|Female
Michael|Male
Linda|Female
William|Male
Elizabeth|Female
David|Male
Barbara|Female
Richard|Male
Susan|Female
Joseph|Male
Jessica|Female
Thomas|Male
Sarah|Female
Charles|Male
Margaret|Female
Christopher|Male
Karen|Female
Daniel|Male
Nancy|Female
Matthew|Male
Lisa|Female
Anthony|Male
Betty|Female
Donald|Male
Dorothy|Female
Mark|Male
Sandra|Female
Paul|Male
Ashley|Female
Steven|Male
Kimberly|Female
Andrew|Male
Donna|Female
Kenneth|Male
Emily|Female
George|Male
Carol|Female
Joshua|Male
Michelle|Female
Kevin|Male
Amanda|Female
Brian|Male
Melissa|Female
Edward|Male
Deborah|Female
Ronald|Male
Stephanie|Female
Timothy|Male
Rebecca|Female
Jason|Male
Laura|Female
Jeffrey|Male
Helen|Female
Ryan|Male
Sharon|Female
Jacob|Male
Cynthia|Female
Gary|Male
Kathleen|Female
Nicholas|Male
Amy|Female
Eric|Male
Shirley|Female
Stephen|Male
Angela|Female
Jonathan|Male
Anna|Female
Larry|Male
Ruth|Female
Justin|Male
Brenda|Female
Scott|Male
Pamela|Female
Brandon|Male
Nicole|Female
Frank|Male
Katherine|Female
Benjamin|Male
Samantha|Female
Gregory|Male
Christine|Female
Raymond|Male
Catherine|Female
Samuel|Male
Virginia|Female
Patrick|Male
Debra|Female
Alexander|Male
Rachel|Female
Jack|Male
Janet|Female
Dennis|Male
Emma|Female
Jerry|Male
Carolyn|Female
Tyler|Male
Maria|Female
Aaron|Male
Heather|Female
Henry|Male
Diane|Female
Jose|Male
Julie|Female
Douglas|Male
Joyce|Female
Peter|Male
Evelyn|Female
Adam|Male
Joan|Female
Nathan|Male
Victoria|Female
Zachary|Male
Kelly|Female
Walter|Male
Christina|Female
Kyle|Male
Lauren|Female
Harold|Male
Frances|Female
Carl|Male
Martha|Female
Jeremy|Male
Judith|Female
Gerald|Male
Cheryl|Female
Keith|Male
Megan|Female
Roger|Male
Andrea|Female
Arthur|Male
Olivia|Female
Terry|Male
Ann|Female
Lawrence|Male
Jean|Female
Sean|Male
Alice|Female
Christian|Male
Jacqueline|Female
Ethan|Male
Hannah|Female
Austin|Male
Doris|Female
Joe|Male
Kathryn|Female
Albert|Male
Gloria|Female
Jesse|Male
Teresa|Female
Willie|Male
Sara|Female
Billy|Male
Janice|Female
Bryan|Male
Marie|Female
Bruce|Male
Julia|Female
Noah|Male
Grace|Female
Jordan|Male
Judy|Female
Dylan|Male
Theresa|Female
Ralph|Male
Madison|Female
Roy|Male
Beverly|Female
Alan|Male
Denise|Female
Wayne|Male
Marilyn|Female
Eugene|Male
Amber|Female
Juan|Male
Danielle|Female
Gabriel|Male
Rose|Female
Louis|Male
Brittany|Female
Russell|Male
Diana|Female
Randy|Male
Abigail|Female
Vincent|Male
Natalie|Female
Philip|Male
Jane|Female
Logan|Male
Lori|Female
Bobby|Male
Alexis|Female
Harry|Male
Tiffany|Female
Johnny|Male
Kayla|Female
""".splitlines()

data = [x.split('|') for x in data if len(x) > 0]

new_data = []
for idx, row in enumerate(data, 1):
	k, v = row
	r = random.randint(1,45)
	new_data.append({'id': idx, 'Name': k, 'Gender': v, 'Age': r}) 

with open(os.path.join(current_dir, 'demo_data.json'), 'w') as fout:
    json.dump(new_data, fout, indent=True)
