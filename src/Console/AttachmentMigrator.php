<?php

namespace Hasob\FoundationCore\Console;

use Illuminate\Console\Command;

use App\Models\Attachment;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


class AttachmentMigrator extends Command
{

    protected $signature = 'fc:attachment-migrator';
    protected $description = 'Migrates all attachments to registered cloud s3 destination';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
    
        $attachments = Attachment::whereNull('storage_driver')->where('file_type', '!=','memo')->get();
        $attachments_count = Attachment::whereNull('storage_driver')->where('file_type', '!=','memo')->count();

        echo "Running Attachment Migrator on {$attachments_count} Attachments \n";

        foreach($attachments as $idx => $attachment){
            
            echo "Checking -> {$idx} => {$attachment->id} - {$attachment->path} \n";

            if ($attachment->storage_driver==null && $attachment->file_type!="memo"){
                
                $file_path = app_path()."/../".$attachment->path;
                if (file_exists($file_path)){

                    $file_info = new \SplFileInfo($file_path);
                    $file_extension = $file_info->getExtension();
                    $rndFileName = rand(2112,499995)."-".time().'.'.$file_extension;
                    
                    $file_destination_path = Storage::disk('s3')->putFileAs("migrated-items", new File($file_path),$rndFileName);

                    echo (">>> File Copied to {$file_destination_path} \n");

                    $attachment->path = $file_destination_path;
                    $attachment->storage_driver = "s3";
                    $attachment->save();
                    echo (">>> Attachment Record updated {$attachment->id} \n");
                    echo ("Done \n");
                    
                }
            }

            echo "\n\n";

        }

        echo "Done Uploading Files";
        return 1;
    }

}
