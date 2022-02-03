<?php


namespace App\Services\InstagramGraph;


use App\Models\InstagramPost;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService {


	private $accessToken;

	private $feedLimit;

	private $params = [];

	private $baseUrl = "https://graph.instagram.com/me/media";

	private $fields = "caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";

	/**
	 * InstagramAPI constructor.
	 *
	 * @param $accessToken
	 * @param $feedLimit
	 */
	public function __construct( $accessToken, $feedLimit ) {
		$this->accessToken  = $accessToken;
		$this->feedLimit = $feedLimit;

		$this->params['base_url'] = $this->baseUrl;
		$this->params['access_token'] = $this->accessToken;
		$this->params['fields'] = $this->fields;
		$this->params['limit'] = $this->feedLimit;
	}

	/**
	 * @return Response
	 */
	public function fetch(): Response {
		return Http::get($this->params['base_url'] . '?' . http_build_query($this->params));
	}

	public function refreshFeed() {

		try {

			$feedResponse = $this->fetch();

			if( $feedResponse->successful() ){
				$feed = collect($feedResponse->json()['data'])->transform(function ($item){
					    return $this->fillMissingFields($item);
					})->toArray();

				if( !empty($feed) ){
					$this->deleteFeed();
					InstagramPost::insert($feed);
				}
			}

		} catch (\Exception $e) {
			Log::error('Location: InstagramService refreshFeed Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}
	}

	/*
	 * Needs to fill the collection since Instagram feed response comes with different column count when the field isn't set
	 */
	public function fillMissingFields( $item ) {
		foreach ( explode(',', $this->fields) as $field ) {
			if( !isset($item[$field]) ){
				$item[$field] = NULL;
			}
			$item['timestamp'] = Carbon::parse($item['timestamp'])->format('Y-m-d H:i:s');
		}
		return $item;
	}

	public function deleteFeed() {

		try {

			InstagramPost::query()->delete();

		} catch (\Exception $e) {
		    Log::error('Location: InstagramService deleteFeed Line: ' . $e->getLine(). ' - Message ' . $e->getMessage());
		}
	}

}