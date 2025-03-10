jQuery(document).ready(function($){
	//open/close lateral filter
	jQuery('.mt-addons-sidebar-trigger').on('click', function(){
		triggerFilter(true);
	});
	jQuery('.mt-addons-sidebar .mt-addons-sidebar-close').on('click', function(){
		triggerFilter(false);
	});
	function triggerFilter($bool) {
		var elementsToTrigger = jQuery([jQuery('.mt-addons-sidebar-trigger'), jQuery('.mt-addons-sidebar'), jQuery('.mt-addons-filter'), jQuery('.mt-addons-content-wrapper')]);
		elementsToTrigger.each(function(){
			jQuery(this).toggleClass('filter-is-visible', $bool);
		});
	}
	//mobile version - detect click event on filters tab
	var filter_tab_placeholder = jQuery('.mt-addons-filter .placeholder a'),
		filter_tab_placeholder_default_value = 'Select',
		filter_tab_placeholder_text = filter_tab_placeholder.text();
	
	jQuery('.mt-addons-filter li').on('click', function(event){
		//detect which tab filter item was selected
		var selected_filter = jQuery(event.target).data('type');
			
		//check if user has clicked the placeholder item
		if( jQuery(event.target).is(filter_tab_placeholder) ) {
			(filter_tab_placeholder_default_value == filter_tab_placeholder.text()) ? filter_tab_placeholder.text(filter_tab_placeholder_text) : filter_tab_placeholder.text(filter_tab_placeholder_default_value) ;
			jQuery('.mt-addons-filter').toggleClass('is-open');
		//check if user has clicked a filter already selected 
		} else if( filter_tab_placeholder.data('type') == selected_filter ) {
			filter_tab_placeholder.text(jQuery(event.target).text());
			jQuery('.mt-addons-filter').removeClass('is-open');	
		} else {
			//close the dropdown and change placeholder text/data-type value
			$('.mt-addons-filter').removeClass('is-open');
			filter_tab_placeholder.text(jQuery(event.target).text()).data('type', selected_filter);
			filter_tab_placeholder_text = jQuery(event.target).text();
			
			//add class selected to the selected filter item
			jQuery('.mt-addons-filter .selected').removeClass('selected');
			jQuery(event.target).addClass('selected');
		}
	});
	
	//close filter dropdown inside lateral .mt-addons-sidebar 
	jQuery('.mt-addons-filter-block h4').on('click', function(){
		jQuery(this).toggleClass('closed').siblings('.mt-addons-filter-content').slideToggle(300);
	})
	
	buttonFilter.init();
	jQuery('.mt-addons-content-wrapper ul').mixItUp({
	    controls: {
	    	enable: false
	    },
	    callbacks: {
	    	onMixStart: function(){
	    		jQuery('.mt-addons-fail-message').fadeOut(200);
	    	},
	      	onMixFail: function(){
	      		jQuery('.mt-addons-fail-message').fadeIn(200);
	    	}
	    }
	});
	//search filtering
	var inputText;
	var $matching = jQuery();
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
		    timer = setTimeout(callback, ms);
		};
	})();
	jQuery(".mt-addons-filter-content input[type='search']").keyup(function(){
	  	// Delay function invoked to make sure user stopped typing
	  	delay(function(){
	    	inputText = jQuery(".mt-addons-filter-content input[type='search']").val().toLowerCase();
	   		// Check to see if input field is empty
	    	if ((inputText.length) > 0) {            
	      		jQuery('.mix').each(function() {
		        	var $this = jQuery(this);
		        
		        	// add item to be filtered out if input text matches items inside the title   
		        	if($this.attr('class').toLowerCase().match(inputText)) {
		          		$matching = $matching.add(this);
		        	} else {
		          		// removes any previously matched item
		          		$matching = $matching.not(this);
		        	}
	      		});
	      		jQuery('.mt-addons-content-wrapper ul').mixItUp('filter', $matching);
	    	} else {
	      		// resets the filter to show all item if input is empty
	      		jQuery('.mt-addons-content-wrapper ul').mixItUp('filter', 'all');
	    	}
	  	}, 200 );
	});
});
/*****************************************************
	MixItUp - Define a single object literal 
	to contain all filter custom functionality
*****************************************************/
var buttonFilter = {
  	// Declare any variables we will need as properties of the object
  	$filters: null,
  	groups: [],
  	outputArray: [],
  	outputString: '',
  
  	// The "init" method will run on document ready and cache any jQuery objects we will need.
  	init: function(){
    	var self = this; // As a best practice, in each method we will asign "this" to the variable "self" so that it remains scope-agnostic. We will use it to refer to the parent "buttonFilter" object so that we can share methods and properties between all parts of the object.
    
    	self.$filters = jQuery('.mt-addons-product-filters-content');
    	self.$container = jQuery('.mt-addons-content-wrapper ul');
    
	    self.$filters.find('.mt-addons-filters').each(function(){
	      	var $this = jQuery(this);
	      
		    self.groups.push({
		        $inputs: $this.find('.filter'),
		        active: '',
		        tracker: false
		    });
	    });
	    
	    self.bindHandlers();
  	},
  
  	// The "bindHandlers" method will listen for whenever a button is clicked. 
  	bindHandlers: function(){
    	var self = this;
    	self.$filters.on('click', 'a', function(e){
	      	self.parseFilters();
    	});
	    self.$filters.on('change', function(){
	      self.parseFilters();           
	    });
  	},
  
  	parseFilters: function(){
	    var self = this;
	 
	    // loop through each filter group and grap the active filter from each one.
	    for(var i = 0, group; group = self.groups[i]; i++){
	    	group.active = [];
	    	group.$inputs.each(function(){
	    		var $this = jQuery(this);
	    		if($this.is('input[type="radio"]') || $this.is('input[type="checkbox"]')) {
	    			if($this.is(':checked') ) {
	    				group.active.push($this.attr('data-filter'));
	    			}
	    		} else if($this.is('select')){
	    			group.active.push($this.val());
	    		} else if( $this.find('.selected').length > 0 ) {
	    			group.active.push($this.attr('data-filter'));
	    		}
	    	});
	    }
	    self.concatenate();
  	},
  
  	concatenate: function(){
    	var self = this;
    
    	self.outputString = ''; // Reset output string
    
	    for(var i = 0, group; group = self.groups[i]; i++){
	      	self.outputString += group.active;
	    }
    
	    // If the output string is empty, show all rather than none:    
	    !self.outputString.length && (self.outputString = 'all'); 
	
    	// Send the output string to MixItUp via the 'filter' method:    
		if(self.$container.mixItUp('isLoaded')){
	    	self.$container.mixItUp('filter', self.outputString);
		}
  	}
};