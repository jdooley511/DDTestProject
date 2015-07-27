I created the database tables by using mysql workbench.  The schema dump is located in the included ddtest.sql file.

I also created a mini-web application in order to import the CSV data into the database.  Right now, the import script will clear out the dailyads, orders, and leads table when the form is submitted.  If this was part of an actual application, it's pretty likely we wouldn't want that behavior.  Instead, it would probably be coded to work with existing data. Additionally, this could have been done without the mini web-application by just calling fopen on the actual file locations of the CSV files, instead of the temporary locations where they were uploaded.  

This could have also been done without an actual form submit by using AJAX Upload, and a jQuery $.ajax call upon pressing the submit button (The button would have to be changed to not be type=submit).

The POST page will currently redirect back to index.php after it is done processing the data so that the HTML table can be seen.

I included a screenshot of my web application with the table displayed, as well as the actual HTML to generate the table.  Please let me know if you need me to include anything else.  

Some assumptions that I made that I would request clarification on in a real world environment:

1. Average customer age represents the average age of the customer at the time they clicked the ad, not at the current time.
2. For Best/Worst State - the primary sort is based on number of conversions in the state - so if a person places multiple orders, they still only count as one. A lot of ads ended up with their best/worst states having an equal number of conversions - so I used Total Revenue of the state as a tiebreaker.  I could see use cases for having Conversion % of the state as a tiebreaker, or having total orders placed in the state as a tiebreaker.
3. I omitted the words 'All-time' from the column headers so that the total width of the table would be more in-line with the data contained in the individual cells.
4. In the "Review:" section, it states "ad conversions = number of orders placed by leads who clicked the ad" - I'm assuming that we are still using the earlier definition of a conversion, such that if a lead makes more than one purchase after viewing an ad, it still only counts as one conversion.  If we determine Best/Worst State based on orders placed instead of individual number of conversions per state, it does change the results slightly.
5. While probably not strictly necessary, I included a logical Deleted column in all of my tables.  Using this column instead of actually deleting rows can often be preferential depending on circumstances.
6. I would also get clarification on required precision for all decimal fields.

Other changes / additions I would make in a real world environment:

1. I would probably make an Ad table with some relevant meta data about the specific ad in there.  That way Ad_ID would be an actual Foreign Key into a table.
2. I would make some sort of DB Wrapper class in order to encapsulate the database functionality and provide some sort of persistent connection to use.  This would probably also include a __call method that would automatically route standard getField and setField methods that do simple reads and writes of a single field with no additional functionality.
3. I would definitely make the table look better - and provide mechanisms to sort by any of the existing columns.  We would also want search functionality as the total number of ads got larger.
4. General library code / code organization improvements in order to better facilitate additional development.
5. Test cases for all functions written.
6. Flesh out Lead and Order objects a bit more.  

