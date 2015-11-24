<?php
class DM_Wordpress_Text
{
	static public function nicename($string)
	{
		return str_replace(' - ', '-', preg_replace('/\s+/', ' ',
			mb_convert_case(
				str_replace('-', ' - ', strtolower(trim($string))
			), MB_CASE_TITLE, 'UTF-8')
		));
	}

	static public function truncate($string, $maxWords = 0, $maxChars = 0, $append = ' …')
	{
		$words = mb_split('\s+', $string);
		
		if ($maxWords)
		{
			$words = array_slice($words, 0, (int) $maxWords);
		}
		if ($maxChars)
		{
			$words = array_reverse($words);
			$chars = 0;
			$truncated = array();
			while(count($words) > 0)
			{
				$fragment = trim(array_pop($words));
				$chars += strlen($fragment);

				if($chars > $maxChars) break;

				$truncated[] = $fragment;
			}
		}
		else
		{
			$truncated = $words;
		}

		$result = implode($truncated, ' ');

		return $result . (strlen($string) == strlen($result) ? '' : $append);
	}

	static public function excerpt($string, $limit = 350, $append = ' […]')
	{
		return self::truncate(trim(preg_replace("/\r?\n/", ' ', strip_tags($string))), NULL, $limit, $append);
	}
}