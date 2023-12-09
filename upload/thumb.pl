#!/usr/bin/perl
use warnings;
use strict;
use Image::Thumbnail;

my $imgdir=  "/var/www/upload";

createImageMagickThumb('testFileUploadAndThumb.jpg');


sub createImageMagickThumb {

    my  $filename = shift || '';
    print "file name : $filename\n";
    print "file directory $imgdir\n";
	my $t = new Image::Thumbnail(
		size       => 100,
		create     => 1,
		input      => "$imgdir/$filename",
		outputpath => "$imgdir/thumb.$filename",
	);
    print "input      => $imgdir/$filename\n";
    print "outputpath => $imgdir/thumb.$filename\n";
}
