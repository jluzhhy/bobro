#!/usr/local/bin/perl -w

if (!$ARGV[0]) {
        die "perl PFF.pl InputSeq; \nResult files in Folder InputSeq.PFF \n";
}

my @array =split (/\//,$ARGV[0]);
my $num = @array;
my $name= $array[$num-1];

#my $name=$ARGV[0];

#################     Read sequences

mkdir "$name.PFF" unless -e "$name.PFF";
system "cp -f $ARGV[0] $name.PFF/$name";
system "cp -f $ARGV[0] $name.PFF/$name.fasta";

$Input="$name.PFF/$name";


print "\n1.\tRefining promoter sequences based on $Input...\n";
system "perl bin/PFF1_Refine.pl $name >temp_screen";

print "\n2.\tInfo-rich regions finding....\n\n";
system "perl bin/PFF3_Info-rich.pl $name BCDMPU";
#system "perl bin/PFF3_Info-rich.pl $name BCDMPU";


#system "rm -fr $name.PFF/data/$name\_all $name.PFF/data/Curve";
print "\n\nThe final motif results of $name in $name.PFF/$name.MOTIF\n";
