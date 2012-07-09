<?php

namespace Flame\Models\Newsreel;

interface NewsreelRepository
{
	public function getAll($limit = null);

	public function addOrUpdate(Newsreel $newsreel);

	public function getOne($id);

    public function getBy($conditions, $limit = null);

    public function delete(Newsreel $newsreel);

}