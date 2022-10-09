import java.awt.Color;
import java.util.PriorityQueue;
import java.util.Random;

public class AllocationSimulator {

	class Block implements Comparable<Block> {
		public Block(int addr, int size, int death) {
			this.size = size;
			this.addr = addr;
			this.death = death;
		}

		int addr;
		int size;
		int death;

		public int compareTo(Block other) {
			return death - other.death;
		}
	}

	PriorityQueue<Block> q;
	Random rng;
	Allocator h;
	Validator validator;
	final int width = 128;
	final int thickness = 8;
	final double halfradius = .5 / width;

	final int words = width * width;
	int freewords = words;
	
	int time = 0;

	public AllocationSimulator() {
		q = new PriorityQueue<Block>();
		rng = new Random(0);
		h = new Allocator(words);
		validator = new Validator(words);

		StdDraw.setCanvasSize(thickness * width, thickness * width);
		StdDraw.enableDoubleBuffering();
	}

	public static void main(String[] args) throws InterruptedException {
		AllocationSimulator as = new AllocationSimulator();

		for (int i = 0; i < 10000; i++) {
			as.time = i;
			if (as.rng.nextInt(as.words) < as.freewords)
				as.randomAlloc();
			else
				as.randomFree();
			//Thread.sleep(10);
		}

	}

	public void randomAlloc() {
		int size = randomSize();
		System.out.printf("[%d] Alloue %d indices... ", time, size);

		try {
			int addr = h.alloc(size);
			System.out.printf("addr:%d\n", addr);
			
			
			if (!validator.isfree(addr, size))
				throw new Error("La plage n'est pas libre");
			validator.alloc(addr, size);

			int death = time + (1 << rng.nextInt(6));

			q.offer(new Block(addr, size, death));
			drawBlock(StdDraw.BOOK_BLUE, addr, size);
			freewords -= size;
		} catch (RuntimeException e) {

			System.out.printf("FAIL\n");
		}
	}

	public void randomFree() {
		if (!q.isEmpty()) {
			Block b = q.poll();
			h.free(b.addr, b.size);
			validator.free(b.addr, b.size);
			System.out.printf("[%d] Libère la plage addr:%d size:%d\n", time, b.addr, b.size);
			drawBlock(StdDraw.WHITE, b.addr, b.size);
			freewords += b.size;
		}
	}

	public void drawBlock(Color c, int addr, int size) {
		StdDraw.setPenColor(c);
		StdDraw.setPenRadius((c == StdDraw.WHITE ? 1.1 : .9) / width * 1.2);
		while (size > 0) {
			int offset = addr % width;
			int linelength = Math.min(size, width - offset);
			int eol = offset + linelength - 1;

			double x0 = (double) offset / width + halfradius;
			double y = 1 - ((double) (addr / width) / width + halfradius);
			double x1 = (double) eol / width + halfradius;
			
			StdDraw.line(x0, y, x1, y);

			addr += linelength;
			size -= linelength;
		}
		StdDraw.show();
	}

	public int randomSize() {
		int n = 1;
		while (rng.nextInt() > 0) {
			n *= 2.5;
		}
		return 1 + rng.nextInt(n);
	}

}
