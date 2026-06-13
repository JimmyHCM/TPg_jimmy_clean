<?php

namespace Box\Spout\Reader;

use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Common\Helper\GlobalFunctionsHelper;
use Box\Spout\Common\Type;

/**
 * Class ReaderFactory
 * This factory is used to create readers, based on the type of the file to be read.
 * It supports CSV and XLSX formats.
 *
 * @package Box\Spout\Reader
 */
class ReaderFactory
{
    /**
     * This creates an instance of the appropriate reader, given the type of the file to be read
     *
     * @api
     * @param  string $readerType Type of the reader to instantiate
     * @return ReaderInterface
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     */
    public static function create($readerType)
    {
        $reader = null;

        if ($readerType == Type::CSV)
        {
            $reader = new CSV\Reader();
        }
        else if ($readerType == Type::XLSX)
        {
            $reader = new XLSX\Reader();
        }
        else if ($readerType == Type::ODS)
        {
            $reader = new ODS\Reader();
        }
        else
        {
            throw new UnsupportedTypeException('No readers supporting the given type: ' . $readerType);
        }

        $reader->setGlobalFunctionsHelper(new GlobalFunctionsHelper());

        return $reader;
    }
}
