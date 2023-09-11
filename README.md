# SortedLinkedList

Do you really use linked lists? I met them at the grammar school in the 1st year of programming lessons in 1986 and I haven't needed them since. Even then, I thought it was a terribly stupid thing, because it is terribly slow to access the value in the middle of the list (it has to be traversed step-by-step) unlike, for example, an array. In addition, it is also memory-intensive due to the need to store a link to the next (eventually previous) element. There is low instruction level parallelism - while traversing a linkded list, the CPU doesn't have a lot of work to do because it cannot start processing the next node until it has finished loading the current node.

I used a two-way linked list. It makes it easier and faster to delete the last element of the list (I don't have to loop through the whole list). The disadvantage is a higher memory requirement (each node must contain a link not only to the next one, but also to the previous one).

The advantage of a two-way linked list is that if I know, for example, that the data in the sorted list has a normal distribution, I can adjust the method for adding/deleting so that when the min. value 1, max 10000 and I will want to insert/delete 7000, so I will traverse from back to front.

To decide whether to choose a one-way/two-way linked list and whether to sort it in ascending/descending order, it would be necessary to know more about what it is to be used for, how the data that will be filled into it will look like, if, for example, the data will go in sorted order, than we can modify add to add to the beginning/end, how important is time or memory consumption etc.

When sorting two lists, I use the fact that they are both sorted. Of course, I could call the add() method on each element of the list being added, which would go through the first list from the beginning and put it in the right place. Since they are both sorted, I just need to remember the pointer to where I added the element in the list I'm adding to and continue from there.

The assignment does not specify how the lists with string values should be sorted. I use sort by system settings. Since int values are compared using </=/> and string values using compare, I modified function compare so that it can also compare int values so that I don't have to find out what type the values are every time. Perhaps it would be more efficient to simply retype int to string and then use the compare.

It would be worth considering that the Node contains not only the value, but also the number of times the value occurs. It would simplify adding and removing nodes - it would only be enough to increment/decrement the number and pointers would not have to be solved (unless all Nodes with a given value were deleted).

I use the __toString() methods to clearly display information about lists for testing purposes (var_dump objects with pointers is very confusing). I want to be sure that the code is functional, so I wrote unit tests for it.

Since you say you use your own rules for PHPStan, I also ran the code through PHPStan level 9.

I never use recursion due to extreme memory requirements.

It should be a libraty, so I registered the code as a package on packagist.org as ryvova/linkedlist