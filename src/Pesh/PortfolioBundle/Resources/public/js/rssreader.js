var localFeeds = [];
var items = [];

mergeLocalFeeds();

function mergeLocalFeeds(tags)
{
	$.ajax({
		url : localrss,
		dataType : "json",
		success : function(data) {
			if(data.feeds) {
				$.each(data.feeds, function(i,e) {
					var match = false;
					if (tags !== undefined && Array.isArray(tags) && tags.length) {
						for (var i=0; i < e.tags.length; i++) {
							if (tags.indexOf(e.tags[i]) != -1) {
								match = true;
							}
						}
						if (match) {
							localFeeds.push(e);
						}
					}
					else {
						localFeeds.push(e);
					}
				});

				loadFeeds();
			}
		}
	});
}

function loadFeeds()
{
	var count = 0;
	for (var i = 0; i < localFeeds.length; i++)
	{
		$.ajax({
			url : ajaxproxy + encodeURIComponent(encodeURIComponent(localFeeds[i].src)),
			type : "GET",
			dataType : "xml",
			success : function(feed) {
				items.push.apply(items, $(feed).find("item"));
			}

		}).complete(function() {
			count++;

			if (count == localFeeds.length){
				sortByDate(false);
				
				for (var j = 0; j < items.length; j++){
					printItem(items[j]);
				}
			}
		});
	}
}

function sortByDate(distinct)
{
	items.sort(compare);

	distinct = typeof distinct !== 'undefined' ? distinct : false;
	
	if(distinct)
		for (var j,i = 0; i < (items.length-1); i++)
			for (j = items.length; j > i+1; j--)
				if ($(items[i]).find('link') == $(items[j]).find('link'))
					items.splice(j, 1);

}

function compare(a,b)
{
	if (getDate(a) == "Invalid Date")
		return 1;
	if (getDate(a) < getDate(b))
		return 1;
	else
		return -1;
}

function getDate(item)
{
	var date;
	date = new Date($(item).find('pubDate').text());
	
	if (date == "Invalid Date")
		date = new Date($(item).find('date').text());
		
	return date;
}

function printItem(item)
{
	divItem = document.createElement('div');
	divItem.className = "item";

	pItemTitle = document.createElement('p');
	pItemTitle.className = "item-title";

	aItemLink = document.createElement('a');
	aItemLink.className = "item-link";
	aItemLink.href = $(item).find('link').text();
	aItemLink.innerHTML = $(item).find('title').text();

	pItemDate = document.createElement('p');
	pItemDate.className = "item-date";
	var date;
	date = new Date($(item).find('pubDate').text());
	if (date == "Invalid Date")
		date = new Date($(item).find('date').text());
	pItemDate.innerHTML = date.toLocaleString();

	pItemDescription = document.createElement('p');
	pItemDescription.className = "item-description";
	pItemDescription.innerHTML = $(item).find('description').text();

	$(divItem).append($(pItemTitle).append(aItemLink), pItemDate, pItemDescription, document.createElement('hr'));
	$('#rss-viewer').append(divItem);
}