import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SegurosComponent } from './seguros.component';

describe('SegurosComponent', () => {
  let component: SegurosComponent;
  let fixture: ComponentFixture<SegurosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SegurosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SegurosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
