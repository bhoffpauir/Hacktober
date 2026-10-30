/**
* Get the summary for the article (separate model/database table).
*/
public function summary(): HasOne
{
    return $this->hasOne(ArticleSummary::class);
}
