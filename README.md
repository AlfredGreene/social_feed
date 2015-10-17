# Social feed.
Read a number of post from twitter, facebook ore any other provider.

Social_feed can be used get easy access to facebook page posts and tweets ordered by date. But it should be easy to ad other sources using the IStreamProvider inverface. If someone would like to add a rss reader I'd be happy to accept your pull request.

## Example ussage.

Create an app for twitter at https://apps.twitter.com/ , add your app and click on the link after your consumer key to get the access code.
```
$twProvider = new TwitterProvider(new TwitterAPIExchange([
    'consumer_key' => 'twitter provides consumer key',
    'consumer_secret' => 'secret',
    'oauth_access_token' => 'access token',
    'oauth_access_token_secret' => 'tokensecret',
]),[
    'user_id' => 'your twitter user id', 
    'count' => 5 /*posts to read*/,
])
````

Create a facebook app at https://developers.facebook.com/. You need a client accesstoken as well to read post from a page.

```
$fbProvider = new FacebookProvider(new Facebook([
  'app_id' => 'your app id',
  'app_secret' => 'your app secret',
  'default_graph_version' => 'v2.5',
]), 'your page id', 5 /* posts to read*/, 'your accesstoken')
```

After that you can combine them and read them in a single stream.
```
$combination = new CombinationStream();
$combination->addProvider($fbProvider);
$combination->addProvider($twProvider);

foreach($combination->readStream() as $msg) {
    echo $msg->getDate()->format(DateTime::W3C) . ' ' . $msg->getMessage(). PHP_EOL . PHP_EOL;
}
```
