<?php
class Post extends Eloquent 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Posts';
    
    protected $fillable  = ['Details','Description'];

    public $timestamps = false;

   public static $rules = array(
    'Description'  => 'required',
    'Details'      => 'required',
    );
    /**
     * @brief Relationship to Publisher
     * @return  Relationship
     */
    public function Publisher()
    {
        return $this->belongsTo('Publisher','ID','Publisher');
    }

    public function scopeSearch($query,$keyword){
       
       return $query->where('Status','=','Open')
                    ->where("Details", "LIKE", "%$keyword%")
                    ->orWhere("Description", "LIKE", "%$keyword%");
    }
}
