<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 23/05/2018
 * Time: 19:13
 */

namespace App\Service;


use App\Entity\Instance;

class InitService
{
    /**
     * @param array $data
     * @return Instance
     */
    public function instance(array $data): Instance
    {
//        if (empty($data))
//            return new Instance();
//        return new Instance();
    }
}



/*
 *   [ 
  0 =>   [ 
    "AmiLaunchIndex" => 0
    "ImageId" => "ami-8ee056f3"
    "InstanceId" => "i-02fd0dbb76cb58a57"
    "InstanceType" => "t2.micro"
    "KeyName" => "ys-dev"
    "LaunchTime" => DateTimeResult @1524148776 {#295  
      date: 2018-04-19 14:39:36.0 +00:00
    }
    "Monitoring" =>   [ 
      "State" => "disabled"
    ]
    "Placement" =>    [ 
      "AvailabilityZone" => "eu-west-3c"
      "GroupName" => ""
      "Tenancy" => "default"
    ]
    "PrivateDnsName" => "ip-172-31-42-155.eu-west-3.compute.internal"
    "PrivateIpAddress" => "172.31.42.155"
    "ProductCodes" => []
    "PublicDnsName" => ""
    "State" =>    [ 
      "Code" => 80
      "Name" => "stopped"
    ]
    "StateTransitionReason" => "User initiated (2018-04-19 14:40:50 GMT)"
    "SubnetId" => "subnet-38938f72"
    "VpcId" => "vpc-c73e98ae"
    "Architecture" => "x86_64"
    "BlockDeviceMappings" =>   [ 
      0 =>    [ 
        "DeviceName" => "/dev/xvda"
        "Ebs" => array:4 [ 
          "AttachTime" => DateTimeResult @1518775278 {#357 ▶}
          "DeleteOnTermination" => true
          "Status" => "attached"
          "VolumeId" => "vol-05a5052127c9c468c"
        ]
      ]
    ]
    "ClientToken" => ""
    "EbsOptimized" => false
    "EnaSupport" => true
    "Hypervisor" => "xen"
    "NetworkInterfaces" =>   [▶]
    "RootDeviceName" => "/dev/xvda"
    "RootDeviceType" => "ebs"
    "SecurityGroups" =>   [▶]
    "SourceDestCheck" => true
    "StateReason" =>    [▶]
    "Tags" =>    [▶]
    "VirtualizationType" => "hvm"
    "CpuOptions" =>    [ 
      "CoreCount" => 1
      "ThreadsPerCore" => 1
    ]
  ]
]*/
