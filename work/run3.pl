#!/usr/bin/perl
use Cwd;
use strict;
use warnings;
use FindBin qw($Bin);
system("perl $Bin/workspace/pipe_step_2_motif.pl  $ARGV[0]/$ARGV[1].ptt $ARGV[0]/$ARGV[1].fna $ARGV[0]/$ARGV[1].faa $ARGV[0]/$ARGV[1].opr $ARGV[0]  $ARGV[1]");
opendir(THISDIR,"$ARGV[0]/ortholog_promoter");
my @dirList = readdir THISDIR;
foreach my $dir (@dirList)
{
   if($dir=~/job\_[0-9]*\.sh/)
     {
       system("sh $Bin/qsub1.sh $Bin/workspace $ARGV[0]/ortholog_promoter $dir");
       sleep(10);
     
      }
}
  system("rm -f $ARGV[0]/ortholog_promoter/job_[0-9]*.sh");


  