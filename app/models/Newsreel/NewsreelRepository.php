<?php

namespace Model\Newsreel;

interface NewsreelRepository
{
	public function findAll($limit = null);

	public function persist(Newsreel $new);

	public function findOne($id);

    public function addOrUpdate(Newsreel $newsreel);
}