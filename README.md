# Pagination
Simple Pagination Utility for PHP

# Example
```
<?php
	// Include Pagination
	include("util/pagination.php");
	
	// Set current page
	$CurrentPage = 1;
	if ( isset($_GET['p']) )
		$CurrentPage = $_GET['p'];
	
	// Define our elements (ideally from a Database)
	$Elements = [
		"Employee 1",
		"Employee 2",
		"Employee 3",
		"Employee 4",
		"Employee 5",
		"Employee 6",
		"Employee 7",
		"Employee 8",
		"Employee 9",
		"Employee 10",
		"Employee 11",
		"Employee 12",
	];
	
	// Setup paginator
	$Paginator = new Pagination();
	$Paginator->setElementsPerPage(5); // 5 elements per page.
	$Paginator->setBoundaryPages(2); // 2 pages to the left/right of current page.
	$Paginator->setTotalElements(count($Elements)); // Total # elements for paging.
	$Paginator->setCurrentPage($CurrentPage);
	
	// Display Page elements
	$DataOffset = $Paginator->getDataOffset(); // Offset so we know where to start querrying Elements
	$ElementsPerPage = $Paginator->getElementsPerPage(); // How many elements we want to display per page
	for ( $i = 0; $i < $ElementsPerPage; $i++ ) {
		$index = $i + $DataOffset;
		
		// Avoid NPE
		if ( $index >= count($Elements) )
			continue;
		
		// Grab element and display
		$Element = $Elements[$index];
		echo('<div style="width:100px; height:100px; display:table-cell; text-align:center; vertical-align:middle; background-color:RED;">'.$Element.'</div>');
	}
	
	// Display Page navigation
	$PageBoundary = $Paginator->getLocalPageRange();
	echo("<div>");
	echo("<a href='members.php?p=".$Paginator->getFirstPage()."'>First </a>");
	for ( $i = 0; $i < count($PageBoundary); $i++ ) {
		$PageIndex = $PageBoundary[$i];
		echo("<a href='members.php?p=".$PageIndex."'>".$PageIndex." </a>");
	}
	echo("<a href='members.php?p=".$Paginator->getLastPage()."'>Last </a>");
	echo("</div>");
?>
```
