/*
 * Async Treeview 0.1 - Lazy-loading extension for Treeview
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-treeview/
 *
 * Copyright (c) 2007 Jörn Zaefferer
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Revision: $Id: jquery.treeview.async.js 8040 2011-08-11 15:21:09Z aFolletete $
 *
 */

;(function($jqPm) {

function load(settings, root, child, container) {
	function createNode(parent) {
		var id_category = this.id_category;
		var checked = false;
		$jqPm('input[name="'+inputName+'"][type=hidden]').each( function () {
			if ($jqPm(this).attr('value') == id_category)
			{
				checked = true;
				$jqPm(this).remove();
			}
		});
		var current = $jqPm("<li/>").attr("id", this.id_category || "").html(" <input type=\""+(!use_radio ? 'checkbox' : 'radio')+"\" value=\""+this.id_category+"\"/ name=\""+inputName+"\" "+(checked ? 'checked' : '')+" onclick=\"clickOnCategoryBox($jqPm(this));\"/> <span class=\"category_label\">" + this.name +"</span>"+(this.has_children>0 && !use_radio?" <input type=\"checkbox\" class=\"check_all_children\" onclick=\"checkChildrenCategory(this,"+this.id_category+")\"  /> <small>Check all children</small> ":'')+" <span class=\"category_level\" style=\"display: none;\">" + this.level_depth +"</span> <span class=\"nb_sub_cat_selected\" style=\"font-weight: bold;"+(this.nbSelectedSubCat == 0 ? 'display: none;' : '')+"\">(<span class=\"nb_sub_cat_selected_value\">"+this.nbSelectedSubCat+"</span> "+selectedLabel+")</span>").appendTo(parent);
		if (this.classes) {
			current.children("span").addClass(this.classes);
		}
		if (this.has_children > 0) {
			var branch = $jqPm("<ul/>").hide().appendTo(current);
			current.addClass("hasChildren");
			createNode.call({
				classes: "placeholder",
				name: "&nbsp;",
				children:[]
			}, branch);
			branch.children().children('.nb_sub_cat_selected').remove();
		}
	}
	$jqPm.ajax($jqPm.extend(true, {
		url: settings.url,
		dataType: "json",
		data: {
			id_category_parent: root
		},
		success: function(response) {
			child.empty();
			$jqPm.each(response, createNode, [child]);
	        $jqPm(container).treeview({
	        	add: child
	        });
			readyToExpand = true;
	    }
	}, settings.ajax));
}

var proxied = $jqPm.fn.treeview;
$jqPm.fn.treeview = function(settings) {
	if (!settings.url) {
		return proxied.apply(this, arguments);
	}
	var container = this;
	if (!container.children().size())
		load(settings, "source", this, container);
	var userToggle = settings.toggle;
	return proxied.call(this, $jqPm.extend({}, settings, {
		collapsed: true,
		toggle: function() {
			var $this = $jqPm(this);
			if ($this.hasClass("hasChildren")) {
				var childList = $this.removeClass("hasChildren").find("ul");
				load(settings, this.id, childList, container);
			}
			if (userToggle) {
				userToggle.apply(this, arguments);
			}
		}
	}));
};

})($jqPm);
