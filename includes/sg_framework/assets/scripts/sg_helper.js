function strToSlug(str, sep){
	if(typeof sep == 'undefined'){
		sep = '-';	
	}
	
	return str.toLowerCase().replace(/[^a-zA-Z0-9]+/g,sep).replace(/-_ +/g,sep);	
}

String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
};