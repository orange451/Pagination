<?php
	class Pagination {
		var $elementsPerPage;
		var $totalElements = 1;
		var $currentPage = 1;
		var $boundaryPages = 2;
		
		function __construct($elementsPerPage = 25) {
			$this->setElementsPerPage($elementsPerPage);
			$this->setCurrentPage($this->getFirstPage());
		}
		
		/**
		* Sets the amount of elements that should be displayed per page.
		*/
		function setElementsPerPage($elementsPerPage) {
			$this -> elementsPerPage = $elementsPerPage;
		}
		
		/**
		* Returns the amount of elements that should be displayed per page.
		*/
		function getElementsPerPage() {
			return $this->elementsPerPage;
		}
		
		/**
		* Sets the current page in the pagination. Will change the value of the local page range.
		*/
		function setCurrentPage($currentPage) {
			if ( $currentPage > $this->getLastPage() )
				$currentPage = $this->getLastPage();
			
			if ( $currentPage < $this->getFirstPage() )
				$currentPage = $this->getFirstPage();
			
			$this -> currentPage = $currentPage;
		}
		
		/**
		* Returns the current page.
		*/
		function getCurrentPage() {
			return $this->currentPage;
		}
		
		/**
		* Sets the total amount of elements in the pagination.
		*/
		function setTotalElements($totalElements) {
			$this -> totalElements = $totalElements;
		}
		
		/**
		* Returns the total set elements.
		*/
		function getTotalElements() {
			return $this -> totalElements;
		}
		
		/**
		* Sets the amount of boundary pages on either side of the current page in the local page range.
		*/
		function setBoundaryPages($boundaryPages = 2) {
			$this -> boundaryPages = $boundaryPages;
		}
		
		/**
		* Returns the amount of boundary pages on either side of the current page.
		*/
		function getBoundaryPages() {
			return $this->boundaryPages;
		}
		
		/**
		* Returns the local range of pages around your pagination. Example: [1, 2, CURRENT(3), 4, 5].
		*/
		function getLocalPageRange() {
			$leftRemoved = 0;
			$leftIndex = $this->getCurrentPage() - $this->getBoundaryPages();
			if ( $leftIndex < $this->getFirstPage() ) {
				$leftRemoved = abs($leftIndex-$this->getFirstPage());
				$leftIndex = $this->getFirstPage();
			}
			
			$rightRemoved = 0;
			$rightIndex = $this->getCurrentPage() + $this->getBoundaryPages();
			if ( $rightIndex > $this->getLastPage() ) {
				$rightRemoved = abs($rightIndex-$this->getLastPage());
				$rightIndex = $this->getLastPage();
			}
			
			$leftIndex -= $rightRemoved;
			$rightIndex += $leftRemoved;
			
			$array = [];
			for ($i = 0; $i <= ($rightIndex - $leftIndex); $i++ ) {
				$array[$i] = $leftIndex + $i;
			}
			
			return $array;
		}
		
		/**
		* Returns the data offset based on the current page. Used when LIMITing results when querried from a database.
		* Example sql/php: select * from employees LIMIT {getElementsPerPage()} {getDataOffset()}
		*/
		function getDataOffset() {
			return $this->getElementsPerPage() * ($this->getCurrentPage()-1);
		}
		
		/**
		* Returns the last page index.
		*/
		function getLastPage() {
			if ( $this->getTotalElements() < 1 )
				return $this->getFirstPage();
			
			return ceil($this->getTotalElements() / $this->getElementsPerPage());
		}
		
		/**
		* Returns the first page index. Should be 1.
		*/
		function getFirstPage() {
			return 1;
		}
		
		/**
		* Returns true if the current page is equal to the first page.
		*/
		function isOnFirstPage() {
			$this->getCurrentPage() == $this->getFirstPage();
		}
		
		/**
		* Returns true if the current page is equal to the first page.
		*/
		function isOnLastPage() {
			$this->getCurrentPage() == $this->getLastPage();
		}
		
		/**
		* Returns if the specified page has a next page.
		*/
		function hasNextPage($pageIndex) {
			if ( !isset($pageIndex) )
				$pageIndex = $this->getCurrentPage();
			
			return $pageIndex + 1 <= $this->getLastPage();
		}
		
		
		/**
		* Returns if the specified page has a previous page.
		*/
		function hasPreviousPage($pageIndex) {
			if ( !isset($pageIndex) )
				$pageIndex = $this->getCurrentPage();
			
			return $pageIndex - 1 >= $this->getFirstPage();
		}
	}
?>
