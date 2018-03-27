rm -rf *.txt

cat apnic | awk -F '|' '/CN/&&/ipv4/ {print $4 "/" 32-log($5)/log(2)}' > cn.txt

php merge.php cn.txt > final-cn.txt

cat lan final-cn.txt | sort -n -t . -k1,1 -k2,2 -k3,3 > tmp.txt

php gl.php | sort -n -t . -k1,1 -k2,2 -k3,3 > tmp.gl.txt

cat tmp.gl.txt | awk -F '.' '{print $1"."$2}' | uniq -c | awk '{if($1>10)print $2,$1}' > tmp.more.txt

php more.php >> tmp.gl.txt 

cat gl.a >> tmp.gl.txt

cat tmp.gl.txt | sort -n -t . -k1,1 -k2,2 -k3,3 > gl.txt

php merge.php gl.txt > final-gl.txt
