<?php
session_start();
if (!isset($_SESSION['oauth_token']) || !isset($_SESSION['oauth_token_secret'])) { 
	if (isset($_COOKIE['twixxee'])) {
		$token = explode(':', base64_decode($_COOKIE['twixxee']));
		$_SESSION['oauth_token'] = $token[0];
		$_SESSION['oauth_token_secret'] = $token[1];
	} else {
		Header("Location: /oauth/login"); 
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Twixxee</title>
		<link rel="stylesheet" type="text/css" href="css/teapot.css" title="default "/>
		<link rel="alternate stylesheet" type="text/css" href="css/teapot-dark.css" title="dark"/>
		<link rel="alternate stylesheet" type="text/css" href="css/teapot-smallscreen.css" title="smallscreen"/>
		<script type="text/javascript" src="libs/jquery-1.4.2.js"></script>		
		<script type="text/javascript" src="libs/jquery-ui-1.8rc2.js"></script>
		<script type="text/javascript" src="libs/trimpath-template-1.0.38.js"></script>
		<script type="text/javascript" src="src/utils.js"></script>
		<script type="text/javascript" src="src/logger.js"></script>
		<script type="text/javascript" src="src/Tweet.js"></script>
		<script type="text/javascript" src="src/JsonApi.js"></script>
        <script type="text/javascript" src="src/PagedList.js"></script>
		<script type="text/javascript" src="src/teapot.js"></script>		
		<script type="text/javascript">
		$(function() {						
			teapot.init(new JsonApi("http://", "twixxee.com/oauth/proxy.php?oauth_token=<?php echo $_SESSION['oauth_token']; ?>&oauth_token_secret=<?php echo $_SESSION['oauth_token_secret']; ?>&endpoint=", "search.twitter.com", 
				teapot.handleError));
			
			$("#aboutLink").click( function(){
				utils.showAbout();
				return false;
			});
		});
		</script>
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body>
		<div style="position: fixed; top: 5px; right: 10px; z-index: 999;"><a href="/oauth/logout">Sign Out</a></div>
		<div class="pagecontents">
			<div class="pagehead">
				<div id="tweetboxcontainer">	
					<form action="" onsubmit="return teapot.sendTweet();">
						<textarea cols="70" rows="2" id="tweettextbox"></textarea>
						<br />
						<input type="submit" id="tweetbutton" value="tweet this" />
						<span id="tweetlengthbox" />
					</form>				
				</div>
				<div class="menubar">
					<a title="Show tweets from the &quot;public&quot; timeline" id="public_timeline" class="menuitem" href="#" onclick="teapot.showPublicTimeline();return false">public</a> 
					<a title="Show tweets of my friends" id="home_timeline" class="menuitem" href="#" onclick="teapot.showHomeTimeline();return false">home</a>  
					<a title="Show my tweets" id="my_timeline" class="menuitem" href="#" onclick="teapot.showMyTimeline();return false">me</a>	
					<a title="Show tweets of one user" id="user_timeline" class="menuitem" href="#" onclick="teapot.showAnyUserTimeline();return false">user</a>			
					<a title="Show replies to my tweets" id="mentions_timeline" class="menuitem" href="#" onclick="teapot.showMentions();return false">replies</a>
					<a title="Show my favorites" id="favorites_timeline" class="menuitem" href="#" onclick="teapot.showFavorites();return false">favs</a>					
					<a title="Search in Twitter" id="search_timeline" class="menuitem" href="#" onclick="teapot.doSearch();return false">search</a>
	                <a title="Flow" id="tools" class="menuitem" href="/flow">flow</a>
				</div>	
			</div>
				
			<div id="messagearea">
			</div>	
			<div id="waitmessage">Please wait...</div>	
			<div id="contentarea"></div>
			<div id="footer">
				<p class="copyright">
					&copy; 2010 <a href="http://7touchgroup.com/">7touch group, inc.</a>
					&nbsp;|&nbsp;
					Based upon the Open Source Project Teapot and Alex Young.
				</p>
				<p class="links">
					<a href="/about" id="aboutLink">about</a>
					&nbsp;|&nbsp;
					<a href="http://7touchgroup.com/contact">contact</a>
					&nbsp;|&nbsp;
					<a href="http://7touchgroup.com/privacy">privacy policy</a>
				</p>
				<span id="requestsremaining"></span>
			</div>
	</div>							
						
<!-- Templates for usage with TrimPath JavaScript Templates -->
<textarea id="template_user_profile" cols="0" rows="0" style="display:none;">
	<div class="userInfoContainer">
		<table class="userinfotable">
			<tr>
				<td style="width:5%">
					<img src="${user.profile_image_url}" alt="User profile of ${user.screen_name}" class="avatar" />
				</td>
				<td style="width:45%">
					<h1>${user.screen_name}</h1>
					<p>${user.name}</p>
					<ul>
					{if user.location}
						<li><strong>Location:</strong> ${user.location}</li>
					{/if}					
					{if user.url}
						<li><strong>Website:</strong> <a href="${user.url}" target="_blank">${user.url}</a></li>
					{/if}	
						<li>Joined Twitter on: ${teapot.formatDateTime(new Date(user.created_at), false)}</li>
					</ul>
					<p>${user.description}</p>										
				</td>
				<td style="width:2%">&nbsp;</td>
				<td valign="top">
					<table class="userDetails" cellspacing="0">
						<tr>
							<td colspan="3" class="userprofilesection">
								Content
							</td>
						</tr>
						<tr>
							<td>
								Tweets
							</td>
							<td class="alignRight">
								<a href="#" onclick="teapot.showUserTimeline('${user.id}');return false">
									${user.statuses_count}
								</a>
							</td>
							<td style="width:5%">
								<a href="http://twitter.com/statuses/user_timeline/${user.id}.rss" target="_blank">							
									<img src="icons/rss.png" width="16" height="16" alt="RSS feed" />
								</a>
							</td>
						</tr>
						<tr>
							<td>
								Favorites
							</td>
							<td class="alignRight">
								<a href="#" onclick="teapot.showFavorites('${user.id}');return false">							
									${user.favourites_count}
								</a>
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="3" class="userprofilesection">
								Social Graph
							</td>
						</tr>
						<tr>
							<td>
								Friends
							</td>
							<td class="alignRight">
								<!-- <a href="#" onclick="teapot.showFriends('${user.id}', '${user.screen_name}', -1);return false"> -->
								${user.friends_count}
								<!-- </a> -->
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						
						<tr>
							<td>
								Followers
							</td>
							<td class="alignRight">
								<!-- <a href="#" onclick="teapot.showFollowers('${user.id}', '${user.screen_name}', -1);return false"> -->
								${user.followers_count}
								<!-- </a> -->
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td class="userprofilesection">
								Actions
							</td>
							<td colspan="2" class="userprofilesection alignRight">
								{if relation.target.followed_by}											
									<a href="#" onclick="teapot.unfollow('${user.id}', '${user.screen_name}');return false">Unfollow</a>
								{else}
									<a href="#" onclick="teapot.follow('${user.id}', '${user.screen_name}');return false">Follow</a>
								{/if}
							</td>
						</tr>
						<tr>
							<td colspan="3">
								{if user.screen_name == teapot.currentUser.screen_name}
									<p>
										<b>This is you.</b>
									</p>
								{/if}							
								{if user.protected}
									<p> 
										This is a protected user.
									</p>
								{/if}
								{if user.screen_name != teapot.currentUser.screen_name}
									<ul>
									{if relation.target.following}
										<li>This user is following you.</li>
									{else}
										<li>This user is not following you.</li>
									{/if}						
									{if relation.target.followed_by}
										<li>You are following this user.</li>
									{else}
										<li>You are not following this user.</li>
									{/if}
									</ul>
								{/if}
							</td>
						</tr>
					</table>
				</td>    		
			</tr>
		</table>
	</div>
</textarea>

<textarea id="template_user" cols="0" rows="0" style="display:none;">
	<div class="itemcontents" id="${id}">
		<a href="#" onclick="teapot.showUserProfile('${id}', '${screen_name}');return false">			
			<img class="avatar" src="${profile_image_url}" width="40" height="40"
				alt="Profile image of ${screen_name}" />			
		</a>
		<span class="tweetusername">
			<a href="#" onclick="teapot.showUserTimeline('${id}', '${screen_name}');return false">
				${screen_name}
			</a>
		</span><br />		
		<span class="smallitemtext">
		${description}
		</span>
		<br clear="all" />
	</div>
</textarea>


<textarea id="template_tweet" cols="0" rows="0" style="display:none;">
    <div class="itemcontents ${authorClass} ${updateClass}" id="_tweetcontents_${tweet.getId()}">
        <a href="#" onclick="teapot.showUserProfile('${tweet.getUserId()}', '${tweet.getUserScreenName()}');return false"
           title="Show ${tweet.getUserScreenName()}'s user profile">
            <img class="avatar" src="${tweet.getUserProfileImageUrl()}" 
                width="40" height="40"
                alt="Profile image of ${tweet.getUserScreenName()}" />
        </a>
        <span class="tweetusername">
            <a href="#" onclick="teapot.showUserTimeline('${tweet.getUserId()}');return false"
                title="Show ${tweet.getUserScreenName()}'s tweets">${tweet.getUserScreenName()}</a>
        </span>
		<span class="smallitemtext">
			[
            <a href="#" onclick="teapot.showSingleTweet('${tweet.getId()}');return false">
                ${dateTime}
            </a>            
            from ${tweet.getSource()}
            {if tweet.getInReplyToStatusId() != null}
                <a href="#" onclick="teapot.showSingleTweet('${tweet.getInReplyToStatusId()}');return false">
                    in reply to ${tweet.getInReplyToScreenName()}    
                </a>
            {/if}
			]
        </span>
		<span class="tweetactions">
            {if authorClass === "mytweet"}
			<a class="delete" href="#" onclick="teapot.deleteTweet('${tweet.getId()}');return false" title="Delete this tweet">
				<span>Delete this tweet</span>
			</a>    
            {/if}
			<a class="fav" href="#" onclick="teapot.fav('${tweet.getId()}');return false" title="Add this tweet to your favorites">
                <span>Add this tweet to your favorites</span>
            </a>
			{if authorClass !== "mytweet"}                
			<a class="retweet" href="#" onclick="teapot.retweet('${tweet.getId()}', '${tweet.getUserScreenName()}');return false" title="Retweet this tweet">
				<span>Retweet this tweet</span>
			</a>
			<a class="reply" href="#" onclick="teapot.replyToTweet('${tweet.getId()}', '${tweet.getUserScreenName()}');return false" title="Reply to this tweet">
				<span>Reply to this tweet</span>
			</a>
            {/if}
        </span>
        <span class="itemtext">
            ${teapot.replaceRegexps(tweet.getText())}<br />
        </span>
    </div>
</textarea>

<div id="aboutText" style="display:none;">
	<p>
		Twixxee is a simple, ultra-fast Twitter client built in HTML5. The way we connect and 
		interact with Twitter is becoming increasingly diverse and as a result, compatibility, 
		dependability and usability have all taken a hit. Into this void steps Twixxee, 
		delivering a superior Twitter experience to the iPad, iPhone and a host of other 
		mobile devices and browsers without the need for a separately running app. Twixxee takes 
		advantage of HTML5's support for a wide array of visual renderings, cleaner markup and 
		better structure to run perfectly across a multitude of platforms and devices. 
		Twixxee, better Tweeting.   
	</p>
</div>
<div id="dialogHolder" style="display:none;">
</div>
<div id="dialogSearch" style="display:none;">
	<form>
		<input type="text" name="searchBox" id="searchBox" class="text" />
	</form>
</div>
<div id="dialogFlow" style="display:none;">
	<div id="flowControls">
		<form>
			Add Search:
			<input type="text" value="" />
			<input type="submit" value="+" />
		</form>
    </div>
</div>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-282101-15']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>