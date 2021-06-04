<?php

class FileBridge
{
    public function file_bridge( $filePath )
    {
        return readfile( $filePath );
    }
}