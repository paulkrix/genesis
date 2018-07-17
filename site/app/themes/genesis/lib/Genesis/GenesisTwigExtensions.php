<?php

class GenesisTwigExtensions {

  function __construct( &$twig ) {
    $twig->addFunction('date_difference', new Twig_SimpleFunction('date_difference', array($this, 'dateDifference')));
    $twig->addFilter('filesize', new Twig_SimpleFilter('filesize', array($this, 'filesize')));
    $twig->addFilter('truncate_to_word', new Twig_SimpleFilter('truncate_to_word', array($this, 'truncateToWord')));
    $twig->addFilter('slugify', new Twig_SimpleFilter('slugify', array($this, 'slugify')));
    $twig->addFilter('pathinfo', new Twig_SimpleFilter('pathinfo', array($this, 'pathinfoFilter')));
  }

  public function dateDifference( $current_post ) {
		$dateFormat = 'd/m/Y';
		$timeFormat = 'G:i:s';
		$dateTimeString = $current_post->date( $dateFormat ) . ' ' . $current_post->time( $timeFormat );
		$postDate = DateTime::createFromFormat( $dateFormat . ' ' . $timeFormat, $dateTimeString );
		$now = new DateTime();
		$interval = $now->diff( $postDate );
		$intervalString = "";
    //Naive approach - fix this if there's time but it won't do any harm if you don't
		if( $interval->y ) {
			$intervalString = $interval->format( '%y year ago' );
      if( $interval->y > 1 ) {
        $intervalString = $interval->format( '%y years ago' );
      }
		} else if( $interval->m ) {
			$intervalString = $interval->format( '%m month ago' );
      if( $interval->m > 1 ) {
        $intervalString = $interval->format( '%m months ago' );
      }
		} else if( $interval->d ) {
			$intervalString = $interval->format( '%d day ago' );
      if( $interval->d > 1 ) {
        $intervalString = $interval->format( '%d days ago' );
      }
		} else if( $interval->h ) {
			$intervalString = $interval->format( '%h hour ago' );
      if( $interval->h > 1 ) {
        $intervalString = $interval->format( '%h hours ago' );
      }
    } else if( $interval->i ) {
			$intervalString = $interval->format( '%i minute ago' );
      if( $interval->i > 1 ) {
        $intervalString = $interval->format( '%i minutes ago' );
      }
		} else if( $interval->s ) {
			$intervalString = $interval->format( '%s second ago' );
      if( $interval->s > 1 ) {
        $intervalString = $interval->format( '%s seconds ago' );
      }
		} else {
			$intervalString = "Just now";
		}

		return $intervalString;
	}

	public function filesize( $file, $humanReadable = true ) {
		$sizeNames = array( 'B', 'KB', 'MB', 'GB' );
		$sizeInBytes = filesize( $file );
		$sizeString = $sizeInBytes;
		if( $humanReadable ) {
			$i = 1;
			for( ; $i < sizeOf( $sizeNames ); $i++ ) {
				if( $sizeInBytes < pow( 1000, $i ) ) {
					break;
				}
			}
			$i--;
			$sizeString = round( $sizeInBytes / pow( 1000, $i ), 2 ) . $sizeNames[ $i ];
		}
		return $sizeString;
	}

  public function truncateToWord($string, $characterLimit, $postfix = "") {
    $parts = preg_split('/([\s\n\r]+)/u', $string, null, PREG_SPLIT_DELIM_CAPTURE);
    $parts_count = count($parts);

    $length = 0;
    $last_part = 0;
    for (; $last_part < $parts_count; ++$last_part) {
      $length += strlen($parts[$last_part]);
      if ($length > $characterLimit) { break; }
    }
    if( strlen($string) <= $characterLimit ) {
      $postfix = "";
    }
    return trim(implode(array_slice($parts, 0, $last_part))) . $postfix;
  }

  public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
      return 'n-a';
    }
    return $text;
  }

  public function pathinfoFilter( $path )
  {
    return pathinfo( $path );
  }


}

?>
