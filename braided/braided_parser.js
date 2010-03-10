
function display_comments (json_response) {
    var braided_comments = document.getElementById("braided-comments");
    
    if (!braided_comments) {
        // fail silently;
        return;
    }
    
    var innerHTML = "<h2>Comments</h2>";
    innerHTML += "<ol>";
    
    for (i = 0; i < json_response.entries.length; i++) {
        innerHTML += display_tp_comment(json_response.entries[i]); 
    }
    innerHTML += "</ol>";
    
    braided_comments.innerHTML = innerHTML;
    return;
}


function display_entry(json_response) {    
    var braided = document.getElementById("braided-entry");
    
    if (!braided) {
        // fail silently
        return;
    }
    
    var innerHTML = "";
    
    innerHTML += add_entry_snippet(json_response);
        
    braided.innerHTML = innerHTML;

    return;
}


function add_entry_snippet (entry) {
    
    var entry_contents = 
'<div class="entry" id="' + entry.urlId + '"> \n' + 
'   <h2>' + get_entry_title(entry) + '</h2>\n' + 
'   <div class="entry-body">\n' +
'       ' + get_entry_contents(entry) +  '\n' +
'   </div>\n' + 
'</div>\n';

    return entry_contents;
}


function get_entry_title (entry) {
    if (entry.title) {
        return entry.title;
    }   
    
    return "[Untitled Entry]";
}

function get_entry_contents (entry) {
    return entry.renderedContent;
}

function add_comments_snippet(entry) {
    var innerHTML = "<h2>Comments</h2>";
    
    // There should only be one entry in this json obj. 
    // Regardless, only work with the first.
    
    innerHTML += '<div class="comment-loop">\n' ;
    innerHTML += '<ul>';
    for (i = 0; i < json_response.entries[0].length; i++) {
        innerHTML += print_individual_comment(json_response.entries[0][i]);
    }
    innerHTML += '</ul>';
    
    return innerHTML;
}


function display_tp_comment (comment) {
    var innerHTML = 
'<div class="comment-outer"> \n' + 
'   <div class="comment-avatar"> \n' + 
'       <img src="' + get_resized_avatar(comment.author, 50) + '" />\n ' + 
'   </div>\n' + 
'   <div class="comment-contents"> \n' + 
'       <p><a href="' + comment.author.profilePageUrl + '">' + get_author_name(comment.author) + '</a> \n' + 
'       said ' + comment.content + '</p>\n ' + 
'   </div>\n' + 
'</div>\n';
    
    return innerHTML;
}


/*****
 * utility features mostly borrowed from Tydget's typepad_parsing.js
 *****/
function get_resized_avatar (user, size) {
    // use the lilypad as a default in case all else fails
    var default_avatar = 'http://up3.typepad.com/6a00d83451c82369e20120a4e574c1970b-50si';
    
    
    for (var i = 0; i < user.links.length; i++) {
        if (user.links[i].rel == "avatar") {
            if (user.links[i].width < 125) {
                return user.links[i].href;
            } 
        }
    }

   return default_avatar;
}
function get_author_name (author_obj) {
    if (author_obj.displayName) {
        return author_obj.displayName;
    }
    
    return "A Member";
}