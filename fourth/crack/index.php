<!DOCTYPE html>
<head><title>John Buchanan Moore MD5 Cracker</title></head>
<body>
<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash
of a four-number string and 
attempts to hash all four-number combinations
to determine the original four number PIN.</p>
<pre>
Debug Output:
<?php
$goodtext = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    // This is our number set
    $txt = "0123456789";
    $show = 15;

    // Outer loop to go through the number set for the
    // first position in our "possible" pre-hash
    // text
    for($i=0; $i<strlen($txt); $i++ ) {
        $ch1 = $txt[$i];   // The first of four numbers

        // Our inner loop Not the use of new variables
        // $j and $ch2 
        for($j=0; $j<strlen($txt); $j++ ) {
            $ch2 = $txt[$j];  // Our second number

            for($k=0; $k<strlen($txt); $k++ ) {
                $ch3 = $txt[$k];  // Our third number

                for($l=0; $l<strlen($txt); $l++ ) {
                    $ch4 = $txt[$l];  // Our fourth number
                    // Concatenate the four numbers together to 
                    // form the "possible" pre-hash text
                    $try = $ch1.$ch2.$ch3.$ch4;

                    // Run the hash and then check to see if we match
                    $check = hash('md5', $try);
                    if ( $check == $md5 ) {
                        $goodtext = $try;
                        break;   // Exit the inner loop
                    }
                
                    // Debug output until $show hits 0
                    if ( $show > 0 ) {
                        print "$check $try\n";
                        $show = $show - 1;
                    }
                }
            }
        }
    }
    // Compute elapsed time
    $time_post = microtime(true);
    print "Elapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<!-- Use the very short syntax and call htmlentities() -->
<p>Original Text: <?= htmlentities($goodtext); ?></p>
<form>
<input type="text" name="md5" size="40" />
<input type="submit" value="Crack MD5"/>
</form>
<ul>
<li><a href="index.php">Reset</a></li>
<li><a href="md5.php">MD5 Encoder</a></li>
<li><a href="makecode.php">MD5 Code Maker</a></li>
<li><a
href="https://github.com/csev/wa4e/tree/master/code/crack"
target="_blank">Source code for this application</a></li>
</ul>
</body>
</html>