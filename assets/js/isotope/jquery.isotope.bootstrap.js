jQuery.Isotope.prototype._bootstrapMasonry = function($) {
		//reset width
		this.element.width('');
	    this.width = this.element.width();    
	    
	    var parentWidth = this.width;
	        
	                  // i.e. options.masonry && options.masonry.columnWidth
	    var colW = this.options.masonry && this.options.masonry.columnWidth ||
	                  // or use the size of the first item
	                  this.$filteredAtoms.outerWidth(false) ||
	                  // if there's no items, use size of container
	                  parentWidth;

	    if(this.$filteredAtoms.outerWidth(false)>colW){
	    	colW = this.$filteredAtoms.outerWidth(false);
	    }
	    
	    var cols = Math.round( parentWidth / colW );
	    cols = Math.max( cols, 1 );

	    console.log('parentwidth',parentWidth)
	    console.log(this.options.masonry && this.options.masonry.columnWidth, this.$filteredAtoms.outerWidth(false), cols)

	    // i.e. this.masonry.cols = ....
	    this.masonry.cols = cols;
	    // i.e. this.masonry.columnWidth = ...
	    this.masonry.columnWidth = colW;
	  };
	  
	  jQuery.Isotope.prototype._masonryReset = function() {
	    // layout-specific props
	    this.masonry = {};
	    // FIXME shouldn't have to call this again
	    this._bootstrapMasonry();
	    var i = this.masonry.cols;
	    this.masonry.colYs = [];
	    while (i--) {
	      this.masonry.colYs.push( 0 );
	    }
	  };

	  jQuery.Isotope.prototype._masonryResizeChanged = function() {
	    var prevColCount = this.masonry.cols;
	    // get updated colCount
	    this._bootstrapMasonry();
	    return ( this.masonry.cols !== prevColCount );
	  };
	  
	  jQuery.Isotope.prototype._masonryGetContainerSize = function() {
	    var unusedCols = 0,
	        i = this.masonry.cols;
	    // count unused columns
	    while ( --i ) {
	      if ( this.masonry.colYs[i] !== 0 ) {
	        break;
	      }
	      unusedCols++;
	    }
	    
	    return {
	          height : Math.max.apply( Math, this.masonry.colYs ),
	          // fit container to columns that have been used;
	          width : (this.masonry.cols - unusedCols) * this.masonry.columnWidth
	        };
	  };