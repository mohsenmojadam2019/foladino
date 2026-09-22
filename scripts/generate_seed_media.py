import hashlib, random, sqlite3
from pathlib import Path
from PIL import Image, ImageDraw, ImageFilter, ImageOps

ROOT=Path(r"C:\xampp\htdocs\foladino")
DB=ROOT/"database"/"database.sqlite"
PD=ROOT/"public"/"images"/"products"
CD=ROOT/"public"/"images"/"categories"
HD=ROOT/"public"/"images"/"hero"
for d in (PD,CD,HD):
    d.mkdir(parents=True,exist_ok=True)
    for p in d.glob("*.jpg"): p.unlink()

def rng_for(key):
    return random.Random(int(hashlib.sha256(key.encode()).hexdigest()[:16],16))

def bg(size,r):
    w,h=size
    g=Image.linear_gradient("L").resize(size)
    top=(12+r.randrange(10),38+r.randrange(14),61+r.randrange(16))
    bot=(3+r.randrange(8),18+r.randrange(10),31+r.randrange(12))
    im=ImageOps.colorize(g,black=top,white=bot)
    d=ImageDraw.Draw(im,"RGBA")
    for _ in range(28):
        x=r.randint(-100,w+100); y=r.randint(-100,h+100); rr=r.randint(70,220)
        d.ellipse((x-rr,y-rr,x+rr,y+rr),fill=(255,255,255,r.randint(3,12)))
    for x in range(0,w,max(90,w//12)):
        d.line((x,0,x+h//2,h),fill=(255,255,255,10),width=1)
    d.polygon([(0,h),(w,h),(w,int(h*.76)),(0,int(h*.9))],fill=(0,0,0,35))
    return im.convert("RGBA")

def rebar(L,r):
    d=ImageDraw.Draw(L,"RGBA"); y=r.randint(430,545); x0=r.randint(70,150)
    for i in range(r.randint(9,14)):
        x=x0+i*r.randint(34,47); yy=y+(i%4)*r.randint(7,14); ln=r.randint(560,900); wd=r.randint(18,28)
        d.rounded_rectangle((x+10,yy+12,x+ln+10,yy+wd+12),radius=wd//2,fill=(0,0,0,70))
        d.rounded_rectangle((x,yy,x+ln,yy+wd),radius=wd//2,fill=(145,158,168,255),outline=(230,235,239,180),width=2)
        for rib in range(x+18,x+ln-10,28): d.line((rib,yy+2,rib-8,yy+wd-2),fill=(75,87,96,220),width=5)
    d.ellipse((x0-32,y-45,x0+52,y+39),fill=(242,112,35,220))

def beam(L,r):
    d=ImageDraw.Draw(L,"RGBA")
    for i in range(r.randint(4,7)):
        x=110+i*r.randint(120,160); y=520-i*r.randint(20,40); ln=r.randint(520,760); f=r.randint(34,48); web=r.randint(16,24)
        d.polygon([(x,y),(x+ln,y-90),(x+ln,y-90+f),(x,y+f)],fill=(190,200,207,255),outline=(238,241,244,180))
        d.polygon([(x+20,y+f),(x+ln-20,y-90+f),(x+ln-20,y-90+f+web),(x+20,y+f+web)],fill=(92,106,117,255))
        d.polygon([(x,y+f+web),(x+ln,y-90+f+web),(x+ln,y-90+f*2+web),(x,y+f*2+web)],fill=(142,156,166,255))

def sheet(L,r):
    d=ImageDraw.Draw(L,"RGBA"); x=r.randint(130,220); y=r.randint(260,350)
    for i in range(r.randint(8,12)):
        o=i*r.randint(12,18)
        d.polygon([(x+o,y+o),(x+740+o,y-70+o),(x+900+o,y+175+o),(x+120+o,y+245+o)],fill=(118+i*6,132+i*6,144+i*6,255),outline=(225,232,238,110))
    cx=r.randint(790,930); cy=r.randint(255,360); rr=r.randint(105,155)
    d.ellipse((cx-rr,cy-rr,cx+rr,cy+rr),fill=(92,106,118,255),outline=(225,232,238,210),width=7)
    d.ellipse((cx-rr//2,cy-rr//2,cx+rr//2,cy+rr//2),fill=(10,32,50,255),outline=(165,179,191,220),width=5)

def pipe(L,r):
    d=ImageDraw.Draw(L,"RGBA"); rr=r.randint(42,60); sx=r.randint(150,230); sy=r.randint(250,330)
    for row in range(r.randint(3,5)):
        for col in range(r.randint(5,7)):
            x=sx+col*(rr*2-8)+(row%2)*rr; y=sy+row*(rr*2-10)
            d.ellipse((x-rr,y-rr,x+rr,y+rr),fill=(156,169,179,255),outline=(234,238,241,210),width=4)
            d.ellipse((x-rr*.66,y-rr*.66,x+rr*.66,y+rr*.66),fill=(14,34,50,255),outline=(85,100,112,255),width=5)
    d.rounded_rectangle((95,610,1090,648),radius=19,fill=(242,112,35,190))

def profile(L,r):
    d=ImageDraw.Draw(L,"RGBA"); s=r.randint(88,120); t=r.randint(12,19); sx=r.randint(150,230); sy=r.randint(260,335)
    n=r.randint(12,18)
    for i in range(n):
        c=i%6; row=i//6; x=sx+c*(s+18)+row*20; y=sy+row*(s+18)-c*10
        d.rounded_rectangle((x,y,x+s,y+s),radius=8,fill=(158,170,180,255),outline=(234,238,241,210),width=3)
        d.rounded_rectangle((x+t,y+t,x+s-t,y+s-t),radius=4,fill=(14,35,52,255),outline=(85,101,113,255),width=2)

def angle(L,r):
    d=ImageDraw.Draw(L,"RGBA")
    for i in range(r.randint(7,10)):
        x=r.randint(100,250)+i*72; y=r.randint(300,420)+i*17; ln=r.randint(520,760); t=r.randint(26,40)
        d.polygon([(x,y),(x+ln,y-100),(x+ln,y-100+t),(x,y+t)],fill=(171,182,191,255),outline=(236,240,243,180))
        d.polygon([(x,y+t),(x+ln,y-100+t),(x+ln-10,y-100+t+110),(x+10,y+t+110)],fill=(87,101,112,255),outline=(201,211,218,160))

M={"rebar":rebar,"beam":beam,"sheet":sheet,"pipe":pipe,"profile":profile,"angle":angle}

def product(slug,cat,out):
    r=rng_for(slug); im=bg((1200,800),r); L=Image.new("RGBA",im.size,(0,0,0,0)); M[cat](L,r)
    L=L.rotate(r.uniform(-2.2,2.2),resample=Image.Resampling.BICUBIC,center=(600,400))
    im=Image.alpha_composite(im,L); d=ImageDraw.Draw(im,"RGBA")
    d.rectangle((0,0,1200,8),fill=(242,112,35,220)); d.rectangle((0,714,1200,800),fill=(3,18,31,70))
    for _ in range(10):
        x=r.randint(30,1170); y=r.randint(30,690); d.ellipse((x,y,x+3,y+3),fill=(255,255,255,r.randint(20,70)))
    im.convert("RGB").save(out,"JPEG",quality=91,optimize=True,progressive=True)

def category(cat,out):
    r=rng_for("category-"+cat); im=bg((1400,900),r); L=Image.new("RGBA",(1200,800),(0,0,0,0)); M[cat](L,r)
    L=L.resize((1400,933),Image.Resampling.LANCZOS); im.alpha_composite(L,(0,-20)); d=ImageDraw.Draw(im,"RGBA"); d.rectangle((0,0,1400,10),fill=(242,112,35,220))
    im.convert("RGB").save(out,"JPEG",quality=92,optimize=True,progressive=True)

def hero(name,out):
    r=rng_for("hero-"+name); im=bg((1800,1100),r); d=ImageDraw.Draw(im,"RGBA"); ground=770
    for _ in range(r.randint(9,14)):
        bw=r.randint(90,230); bh=r.randint(120,390); x=r.randint(-40,1700)
        d.rectangle((x,ground-bh,x+bw,ground),fill=(5,20,34,r.randint(150,220)))
        for wy in range(ground-bh+24,ground-20,44):
            for wx in range(x+18,x+bw-18,42):
                if r.random()<.55: d.rectangle((wx,wy,wx+16,wy+9),fill=(245,164,82,r.randint(55,135)))
    cx=r.randint(250,1250); d.line((cx,330,cx,770),fill=(170,182,192,180),width=10); d.line((cx,330,cx+430,330),fill=(170,182,192,180),width=9)
    cat=list(M)[int(hashlib.sha256(name.encode()).hexdigest()[:2],16)%6]; L=Image.new("RGBA",(1200,800),(0,0,0,0)); M[cat](L,r)
    L=L.resize((1350,900),Image.Resampling.LANCZOS).rotate(r.uniform(-1.2,1.2),resample=Image.Resampling.BICUBIC); im.alpha_composite(L,(420,190))
    d=ImageDraw.Draw(im,"RGBA"); d.polygon([(0,0),(1040,0),(700,1100),(0,1100)],fill=(1,14,25,78)); d.rectangle((0,0,1800,12),fill=(242,112,35,220))
    im.convert("RGB").save(out,"JPEG",quality=93,optimize=True,progressive=True)

con=sqlite3.connect(DB); rows=con.execute("select p.slug,c.slug from products p join categories c on c.id=p.category_id order by c.sort_order,p.id").fetchall(); con.close()
if len(rows)!=180: raise RuntimeError(f"expected 180 products, got {len(rows)}")
counts={}
for slug,cat in rows:
    counts[cat]=counts.get(cat,0)+1; product(slug,cat,PD/f"{slug}.jpg")
if len(counts)!=6 or any(v!=30 for v in counts.values()): raise RuntimeError(counts)
for cat in M: category(cat,CD/f"{cat}.jpg")
for n in ["home-hero","page-hero","price-cta","about-plant","admin-login","order-hero","footer-industry"]: hero(n,HD/f"{n}.jpg")
files=list(PD.glob("*.jpg"))+list(CD.glob("*.jpg"))+list(HD.glob("*.jpg"))
hashes=[hashlib.sha256(p.read_bytes()).hexdigest() for p in files]
if len(files)!=193 or len(hashes)!=len(set(hashes)): raise RuntimeError("media uniqueness/count check failed")
print("generated",len(files),"unique images")
print("counts",counts)
