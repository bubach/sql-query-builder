<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/11/14
 * Time: 1:50 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\SqlQueryBuilder\Builder\Syntax;

use NilPortugues\SqlQueryBuilder\Builder\GenericBuilder;
use NilPortugues\SqlQueryBuilder\Manipulation\Delete;

/**
 * Class DeleteWriter
 * @package NilPortugues\SqlQueryBuilder\BuilderInterface\Syntax
 */
class DeleteWriter
{
    /**
     * @var GenericBuilder
     */
    private $writer;

    /**
     * @var PlaceholderWriter
     */
    private $placeholderWriter;

    /**
     * @param GenericBuilder    $writer
     * @param PlaceholderWriter $placeholder
     */
    public function __construct(GenericBuilder $writer, PlaceholderWriter $placeholder)
    {
        $this->writer            = $writer;
        $this->placeholderWriter = $placeholder;
    }

    /**
     * @param Delete $delete
     *
     * @return string
     */
    public function write(Delete $delete)
    {
        $table = $this->writer->writeTable($delete->getTable());
        $parts = array("DELETE FROM {$table}");

        AbstractBaseWriter::writeWhereCondition($delete, $this->writer, $this->placeholderWriter, $parts);
        AbstractBaseWriter::writeLimitCondition($delete, $this->placeholderWriter, $parts);
        $comment = AbstractBaseWriter::writeQueryComment($delete);

        return $comment.implode(" ", $parts);
    }
}
