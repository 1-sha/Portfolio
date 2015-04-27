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
	for (var i=0; i < localFeeds.length; i++)
	{
		$.ajax({
			url : ajaxproxy + encodeURIComponent(encodeURIComponent(localFeeds[i].src)),
			type : "GET",
			dataType : "xml",
			success : function(feed) {
				items.push.apply(items, $(feed).find("item"));
			}
		});
	}
}