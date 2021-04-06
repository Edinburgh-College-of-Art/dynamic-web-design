<?php
/*
 *      exportrss.php
 *
 *      Copyright 2007 Alec Hussey <alec.hussey@gmail.com>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

class ExportRSS
{
	protected $data = array();
	protected $channel = array();
	protected $rawdata = array();

	public function __construct($data, $version)
	{
		$feed = @file_get_contents($data);
		$this->rawdata = simplexml_load_string($feed);
		
		// Parse the XML/RSS file
		switch ($version)
		{
			case "1.0":
			{
				$this->channel = array(
					"title"       => $this->rawdata->channel->title,
					"link"        => $this->rawdata->channel->link,
					"description" => $this->rawdata->channel->description,
					"image"       => $this->rawdata->channel->image,
					"items"       => $this->rawdata->channel->items,
					"textinput"   => $this->rowdata->channel->textinput
				);
				
				foreach ($this->rawdata->item as $item)
				{
					$row = array(
						"title"       => $item->title,
						"link"        => $item->link,
						"description" => $item->description
					);
					array_push($this->data, $row);
				}
				break;
			}
			case "2.0":
			{
				$this->channel = array(
					"title"       => $this->rawdata->channel->title,
					"link"        => $this->rawdata->channel->link,
					"description" => $this->rawdata->channel->description,
					"language"    => $this->rawdata->channel->language,
					"date"        => $this->rawdata->channel->pubDate,
					"builddate"   => $this->rawdata->channel->lastBuildDate,
					"docs"        => $this->rawdata->channel->docs,
					"generator"   => $this->rawdata->channel->generator,
					"editor"      => $this->rawdata->channel->managingEditor,
					"webmaster"   => $this->rawdata->channel->webMaster,
				);
				
				foreach ($this->rawdata->channel->item as $item)
				{
					$row = array(
						"title"       => $item->title,
						"link"        => $item->link,
						"description" => $item->description,
						"enclosure"   => $this->enclosure
						"date"        => $item->pubDate,
						"guid"        => $item->guid
					);
					array_push($this->data, $row);
				}
				break;
			}
			default:
			{
				echo "ExportRSS::WARNING: invalid version was specified";
				break;
			}
		}
	}
	
	public function get_raw_data()
	{
		return $this->rawdata;
	}
	
	public function get_channel_data()
	{
		return $this->channel;
	}
	
	public function get_data()
	{
		return $this->data;
	}
}
?>