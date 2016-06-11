<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Baum\Node;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxonomy extends Node
{
    use SoftDeletes;
    
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'taxonomies';

    /**
     * Additional attributes
     * 
     * @var array
     */
    protected $appends = ['has_descendants'];

    /**
     * Column name which stores reference to parent's node.
     *
     * @var string
     */
    protected $parentColumn = 'parent_id';

    /**
     * Column name for the left index.
     *
     * @var string
     */
    protected $leftColumn = 'lft';

    /**
     * Column name for the right index.
     *
     * @var string
     */
    protected $rightColumn = 'rgt';

    /**
     * Column name for the depth field.
     *
     * @var string
     */
    protected $depthColumn = 'depth';

    /**
     * Column to perform the default sorting
     *
     * @var string
     */
    protected $orderColumn = 'priority';

    /**
     * With Baum, all NestedSet-related fields are guarded from mass-assignment
     * by default.
     *
     * @var array
     */
    protected $guarded = array('id', 'lft', 'rgt', 'depth');
    protected $fillable = array('name', 'parent_id', 'priority');

    /*
      This is to support "scoping" which may allow to have multiple nested
      set trees in the same database table.
      You should provide here the column names which should restrict Nested
      Set queries. f.ex: company_id, etc.
     */

    /**
     * Columns which restrict what we consider our Nested Set list
     *
     * @var array
     */
    protected $scoped = array();

    /*
      Baum makes available two model events to application developers:

      1. `moving`: fired *before* the a node movement operation is performed.
      2. `moved`: fired *after* a node movement operation has been performed.

      In the same way as Eloquent's model events, returning false from the
      `moving` event handler will halt the operation.

      Please refer the Laravel documentation for further instructions on how
      to hook your own callbacks/observers into this events:
      http://laravel.com/docs/5.0/eloquent#model-events
     */

    /**
     * Model Validation rules for ModelValidatorTrait
     */
    protected $rules = [];

    /**
     * Error Message for ModelValidatorTrait
     * 
     * @var Illuminate\Support\MessageBag
     */
    protected $errorMessages;

    public function languages() {
        return $this->hasMany(Language::class);
    }

    public function translations() {
        return $this->hasMany(TaxonomyTranslation::class, 'taxonomy_id', 'id');
    }

    public function getHasDescendantsAttribute() {
        return !$this->isLeaf();
    }

    public function getChildren() {
        return $this->getDescendants(1);
    }

    static public function getRoots() {
        return self::whereNull('parent_id')->get();
    }

    static public function getTaxonomy($name, $parent_id, $database = null) {
        $tx = new self();
        if (!is_null($database))
            $tx->setConnection($database);
        return $tx->where(['name' => $name, 'parent_id' => $parent_id])->firstOrFail();
    }

}
